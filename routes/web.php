<?php

use App\Http\Controllers\SendEmailController;
use Illuminate\Support\Facades\Route;

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

Route::controller(App\Http\Controllers\FrontendController::class)->group(function () {

    Route::get('/', 'index');
    Route::get('team/create', 'create');
    Route::post('team', 'store');
    Route::get('team/{teams}/edit', 'edit');
    Route::put('team/{teams}', 'update');
    Route::get('team/{teams}/delete', 'destroy');
    Route::get('team/export/', 'export')->name('team.xls');
    Route::post('team/import/', 'import')->name('team.import.xls');
});

Route::get('send-email', [SendEmailController::class, 'index']);

