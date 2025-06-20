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

Route::group(['prefix' => 'gateway/paytr', 'namespace' => 'Modules\Paytr\Http\Controllers', 'as' => 'paytr.', 'middleware' => ['permission:addons']], function () {
    Route::post('/store', 'PaytrController@store')->name('store');
    Route::get('/edit', 'PaytrController@edit')->name('edit');
});

Route::group(['prefix' => 'gateway/paytr', 'namespace' => 'Modules\Paytr\Http\Controllers', 'as' => 'paytr.'], function () {
    Route::view('/payment', 'paytr::payment-form', ['token' => request()->token])->name('show');
    Route::match(['get', 'post'], '/callbackPaytr', 'PaytrController@paytrCallback')->name('callbackPaytr');
});
