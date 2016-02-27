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

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');

Route::resource('properties/customize', 'Property\CustomizeController');
Route::resource('properties/ext', 'Property\ExtController');
Route::post('properties/ref', 'Property\PropertyController@getFromRef');
Route::get('properties/fetch', 'Property\PropertyController@fetch');
Route::resource('properties', 'Property\PropertyController');

Route::resource('res/banner', 'Res\BannerController');
Route::resource('res/launch', 'Res\LaunchController');
Route::post('res/country/update/{id}','Res\CountryController@update');
Route::get('res/country/delete/{id}', 'Res\CountryController@destroy');
Route::resource('res/country', 'Res\CountryController');

Route::resource('files', 'FileController');

Route::post('setting/theme', 'Setting\SettingController@setTheme');
Route::get('setting', 'Setting\SettingController@index');

/* API */
Route::get('api/properties/customize/delete/{id}', 'Property\CustomizeController@delete');
Route::get('api/properties/customize', 'Property\CustomizeController@getAll');

