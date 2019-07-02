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
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/google', 'Auth\LoginController@redirectToGoogleProvider');

Route::get('login/google/callback', 'Auth\LoginController@handleProviderGoogleCallback');

Route::get('/drive/upload', 'DriveController@uploadFile')->name('upload');

Route::post('/drive/upload', 'DriveController@uploadFile');
