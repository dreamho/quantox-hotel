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

Route::middleware(['jwt.auth'])->group(function () {

	Route::post('logout', 'Api\ApiLoginController@logout');
    Route::get('getbyid/{id}', ['uses' => 'Api\ApiSongController@getById', 'middleware' => 'roles', 'roles' => ['admin', 'dj']]);
    Route::get('getsongs', ['uses' => 'Api\ApiSongController@getSongs', 'middleware' => 'roles', 'roles' => ['guest', 'admin', 'dj']]);
    Route::get('delete/{id}', ['uses' => 'Api\ApiSongController@delete', 'middleware' => 'roles', 'roles' => ['admin', 'dj']]);
    Route::post('savesong', ['uses' => 'Api\ApiSongController@saveSong', 'middleware' => 'roles', 'roles' => ['admin', 'dj']]);
    Route::post('editsong', ['uses' => 'Api\ApiSongController@editSong', 'middleware' => 'roles', 'roles' => ['admin', 'dj']]);

});
