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

Route::group(['prefix' => 'gateway/flutterwave', 'as' => 'flutterwave.','middleware' => ['permission:addons']], function () {
    Route::post('/store', 'FlutterwaveController@store')->name('store');
    Route::get('/edit', 'FlutterwaveController@edit')->name('edit');
});
