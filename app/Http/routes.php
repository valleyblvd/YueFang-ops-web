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
    return Redirect::to('properties/customize');
});

Route::get('login','Auth\AuthController@getLogin');
Route::post('login','Auth\AuthController@postLogin');
Route::resource('properties/customize','Property\CustomizeController');
Route::resource('properties/ext','Property\ExtController');
Route::post('properties/ref','Property\PropertyController@getFromRef');
Route::resource('properties','Property\PropertyController');
Route::resource('res/banner','Res\BannerController');
Route::resource('res/launch','Res\LaunchController');
Route::resource('files','FileController');