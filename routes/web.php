<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/confirm/{id}/{token}', 'Auth\RegisterController@confirm');

Route::post('/add_trip', 'TripController@addTrip');

Route::post('/delete_trip', 'TripController@deleteTrip');

Route::get('/get_my_trips', 'TripController@getMyTrips');

Route::get('/get_all_trips', 'TripController@getAllTrips');

Route::get('/test', 'TestController@index');

Route::get('/trip_user/{id}', 'TripController@getTripByUserId');

Route::get('/user/{id}', 'TripController@getTripByUserIdJSon');







