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
Route::get('getroles', 'Api\ApiRegisterController@getRoles');
Route::get('parties', 'Api\ApiPartyController@getParties');

Route::middleware(['jwt.auth'])->group(function () {

    Route::post('logout', 'Api\ApiLoginController@logout');
    Route::get('songs', ['uses' => 'Api\ApiSongController@getSongs', 'middleware' => 'roles', 'roles' => ['guest', 'admin', 'dj']]);
    Route::delete('songs/{id}', ['uses' => 'Api\ApiSongController@deleteSong', 'middleware' => 'roles', 'roles' => ['admin', 'dj']]);
    Route::post('songs', ['uses' => 'Api\ApiSongController@saveSong', 'middleware' => 'roles', 'roles' => ['admin', 'dj']]);
    Route::put('songs/{id}', ['uses' => 'Api\ApiSongController@updateSong', 'middleware' => 'roles', 'roles' => ['admin', 'dj']]);
    Route::post('parties', ['uses' => 'Api\ApiPartyController@saveParty', 'middleware' => 'roles', 'roles' => ['admin', 'party_maker']]);




});
