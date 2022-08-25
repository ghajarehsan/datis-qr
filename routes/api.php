<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'qr'], function () {

    Route::get('qrform', 'QrController@index');

    Route::post('createQr', 'QrController@createQr')->name('qr.createQr');

    Route::get('getAllQr','QrController@getAllQr')->name('qr.getAllQr');

});
