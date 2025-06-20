<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\YooKassa\Http\Controllers\YooKassaController;

Route::group(['prefix' => 'gateway/yookassa', 'as' => 'yookassa.', 'middleware' => ['permission:addons']], function () {
    Route::get('edit', [YooKassaController::class, 'edit'])->name('edit');
    Route::post('store', [YooKassaController::class, 'store'])->name('store');
});
