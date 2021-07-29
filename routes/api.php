<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/conversion', 'App\Http\Controllers\PriceOldController@conversion')->name('conversion');
Route::post('/check-price-old', 'App\Http\Controllers\PriceOldController@checkPriceOld')->name('check-price-old');
Route::post('/check-price-new', 'App\Http\Controllers\PriceNewController@checkPriceNew')->name('check-price-new');