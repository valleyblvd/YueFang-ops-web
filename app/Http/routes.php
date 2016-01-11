<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return Redirect::to('banners');
});

Route::get('login','Auth\AuthController@getLogin');
Route::post('login','Auth\AuthController@postLogin');

Route::resource('clients','ClientController');
Route::resource('properties','PropertyController');


Route::resource('banners','BannerController');
Route::resource('launches','LaunchController');
Route::resource('files','FileController');