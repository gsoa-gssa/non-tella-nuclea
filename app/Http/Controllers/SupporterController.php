<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Supporter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
            "email" => "required|email|unique:supporters,email",
            "data" => "required|array",
            "configuration" => "exists:configurations,key",
            "optin" => "boolean"
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
            "email" => $validated["email"],
            "email_verification_token" => Str::random(32),
        ]);

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
        foreach ($supporters as $supporter) {
            foreach ($supporter->data as $key => $value) {
                $supporter->{$key} = $value;
            }
        }
        $supporters = $supporters->makeHidden("data");
        switch ($validated["format"]) {
            case "csv":
                return Supporter::exportToCsv($supporters);
            case "json":
                return Supporter::exportToJson($supporters);
            case "xlsx":
                return Supporter::exportToXlsx($supporters);
        }
    }
}
