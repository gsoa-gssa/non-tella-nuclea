<?php

namespace App\Http\Controllers;

use App\Models\Supporter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\Validator;

class SupporterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /**
         * Validate the request.
         */
        $validated = $request->validate([
            "email" => "required|email|unique:supporters,pledgeemail",
            "data" => "required|array",
            "configuration" => "exists:configurations,key",
            "optin" => "boolean",
            "public" => "boolean"
        ], [
            "email.required" => __("email is required"),
            "email.email" => __("email is invalid"),
            "email.unique" => __("email is already in use"),
            "data.required" => __("data is required"),
            "data.array" => __("data is invalid"),
        ]);

        /**
         * Create a new supporter. Fail if email is already in use.
         */
        $supporter = Supporter::create([
            "uuid" => Str::uuid(),
            "pledgeemail" => $validated["email"],
            "email_verification_token" => Str::random(32),
        ]);

        /**
         * Remove the email from the data array.
         */
        unset($validated["email"]);

        $supporter->fill($validated);

        $supporter->save();

        if (config("petition")->email_verification) {
            $supporter->sendEmailVerificationNotification();
        }

        return redirect(config("petition")->thanks_url->{app()->getLocale()} )->with("supporter", $supporter);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supporter $supporter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supporter $supporter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supporter $supporter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supporter $supporter)
    {
        //
    }

    /**
     * Export supporters to a CSV file.
     */
    public function exportSupporters(Request $request)
    {
        $validated = $request->validate([
            "format" => "required|in:csv,json,xlsx",
            "configurations" => "array",
        ]);
        foreach ($validated["configurations"] as $configuration) {
            $configuration = Configuration::where("key", $configuration)->first();
            if (!auth()->user()->hasConfiguration($configuration)) {
                abort(403, "You are not allowed to export supporters for this configuration.");
            }
        }
        $supporters = Supporter::whereIn("configuration", $validated["configurations"])->get();
        $fields = Supporter::findDataFields();
        foreach ($supporters as $supporter) {
            foreach ($fields as $field) {
                if (!array_key_exists($field, $supporter->data)) {
                    $supporter->{$field} = null;
                } else {
                    $supporter->{$field} = $supporter->data[$field];
                }
            }
        }
        $supporters->makeHidden("data");
        $filename = "supporters-" . now()->format("Y-m-d-H-i-s");
        switch ($validated["format"]) {
            case "csv":
                return Supporter::exportToCsv($supporters, $filename);
            case "json":
                return Supporter::exportToJson($supporters, $filename);
            case "xlsx":
                return Supporter::exportToXlsx($supporters, $filename);
        }
    }

    /**
     * Allow direct signing through a link.
     */
    public function directSign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|unique:supporters,pledgeemail",
            "data" => "required|array",
            "configuration" => "",
            "optin" => "boolean",
            "data.locale" => "required",
            "public" => "boolean"
        ], [
            "email.required" => __("email is required"),
            "email.email" => __("email is invalid"),
            "email.unique" => __("email is already in use"),
            "data.required" => __("data is required"),
            "data.array" => __("data is invalid"),
            "data.locale.required" => __("locale is required"),
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
            die;
        }

        // Find supporter by email
        $supporter = Supporter::where("pledgeemail", $request->email)->first();
        if ($supporter && $supporter->data["signatureCount"] == $request->data["signatureCount"]) {
            return view("thanks/direct-sign", ["supporter" => $supporter]);
        } else if ($supporter) {
            $supporter->data = $request->data;
            $supporter->save();
            return view("thanks/direct-sign", ["supporter" => $supporter]);
        } else {
            $supporter = Supporter::create([
                "uuid" => Str::uuid(),
                "pledgeemail" => $request->email,
                "email_verification_token" => Str::random(32),
                "data" => [...$request->data, "stage" => "pledge", "method" => "direct-sign"],
            ]);

            return view("thanks/direct-sign", ["supporter" => $supporter]);
        }

    }
}
