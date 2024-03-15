<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupporterController;

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
    return view("landing");
});

Route::get("/{danke}", function() {
    $supporter = request()->session()->get("supporter");
    if (!$supporter && !request()->uuid) {
        return redirect("/");
    } else if (!$supporter) {
        $supporter = \App\Models\Supporter::where("uuid", request()->uuid)->firstOrFail();
    }
    return view("thanks", compact("supporter"));
})->whereIn("danke", ["danke", "merci","grazie"]);

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
    $supporter->email_verification_token = null;
    $supporter->save();
    return redirect("/danke");
})->name("verify-address");

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
