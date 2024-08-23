<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupporterController;
use App\Models\Rnw;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $rnw = new Rnw();
    $rnw->getSum();
    return view("landing.default", compact("rnw"));
});

Route::get('/fundraising', function () {
    $rnw = new Rnw();
    $rnw->getSum();
    return view("landing.fundraising", compact("rnw"));
});

Route::get("/directsign", [SupporterController::class, "directSign"]);

Route::get("/{danke}", function() {
    $supporter = request()->session()->get("supporter");
    if (!$supporter && !request()->uuid) {
        return redirect("/");
    } else if (!$supporter) {
        $supporter = \App\Models\Supporter::where("uuid", request()->uuid)->firstOrFail();
    }
    return view("thanks", compact("supporter"));
})->whereIn("danke", ["danke", "merci","grazie"]);

Route::get("/{spenden}", function() {
    return view("donate");
})->whereIn("spenden", ["spenden", "fair-un-don", "donare"]);

Route::resource('supporters', SupporterController::class)->only([
    'store', 'update'
])->parameters([
    'supporters' => 'supporter:uuid'
])->names([
    'store' => 'supporters.store',
    'update' => 'supporters.update'
]);

Route::get("/verify-address/{uuid}/{email_verification_token}", function($uuid, $email_verification_token) {
    $supporter = \App\Models\Supporter::where("uuid", $uuid)->where("email_verification_token", $email_verification_token)->firstOrFail();
    $supporter->email_verified_at = now();
    $supporter->save();
    return redirect("/danke?uuid=".$uuid);
})->name("verify-address");

if (env("APP_ENV") === "local") {
    Route::get("/email-preview", function() {
        $supporter = \App\Models\Supporter::first();
        if (request()->lang) {
            app()->setLocale(request()->lang);
        }
        return view("emails.verify-email", compact("supporter"));
    })->name("email-preview");

    Route::get("/thanks-preview", function() {
        $supporter = \App\Models\Supporter::first();
        return view("thanks/direct-sign", compact("supporter"));
    })->name("thanks-preview");
}

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
