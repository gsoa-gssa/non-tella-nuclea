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

require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
