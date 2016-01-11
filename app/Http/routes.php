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
    return Redirect::to('res/banners');
});

Route::get('login','Auth\AuthController@getLogin');
Route::post('login','Auth\AuthController@postLogin');

Route::resource('clients','ClientController');
Route::resource('properties','PropertyController');


Route::get('res/banners','ResController@indexBanner');
Route::get('res/banners/create','ResController@createBanner');
Route::get('res/banners/{id}','ResController@showBanner');
Route::post('res/banners','ResController@storeBanner');
Route::get('res/banners/{id}/edit','ResController@editBanner');
Route::put('res/banners/{id}','ResController@updateBanner');
Route::delete('res/banners/{id}','ResController@deleteBanner');
Route::post('res/file','ResController@uploadFile');