<?php

use Illuminate\Http\Request;

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

Route::post('register', 'Api\ApiRegisterController@register');
Route::post('login', 'Api\ApiLoginController@login');

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('getsongs', 'Api\ApiSongController@getSongs');
    Route::get('allsongs', 'Api\ApiSongController@allSongs');
    Route::post('savesong', 'Api\ApiSongController@saveSong');
    Route::post('editsong', 'Api\ApiSongController@editSong');
    Route::get('getbyid/{id}', 'Api\ApiSongController@getById');
    Route::get('delete/{id}', 'Api\ApiSongController@delete');

});

Route::middleware('jwt.auth')->get('users', function(Request $request) {
    return auth()->user();
});