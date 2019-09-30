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
    return view('home');
});


Route::get('property/all', 'PropertyController@getAll');

Route::get('property-types', 'ApiController@getPropertyTypes');
Route::get('statuses', 'ApiController@getStatuses');
Route::get('sale-rent', 'ApiController@getSaleRent');
Route::get('countries', 'ApiController@getCountries');

