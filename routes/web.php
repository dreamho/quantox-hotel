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

Route::get('/', function () {
    return view('home.index');
});

Route::get('songs', 'Api\ApiSongController@index');
Route::get('register', 'Api\ApiRegisterController@showRegisterForm');
Route::get('login', 'Api\ApiLoginController@showLoginForm');
