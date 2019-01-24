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
    return view('welcome');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/user/{user_id}/child/{id}', 'ChildController@show');

    Route::get('/user', 'UserController@index');
    Route::get('/user/{id}', 'UserController@infoWeb')->name('userinfo');
    Route::post('/user/update', 'UserController@update');

    Route::get('/driver', 'DriverController@index');
    Route::get('/driver/{id}', 'DriverController@infoWeb');
    Route::put('/driver/{id}/edit', 'DriverController@update');

    Route::post('/image/create/{id}', 'ImageController@store');
    Route::get('/image/delete/{id}', 'ImageController@destroy');
    Route::put('/image/edit/{id}', 'ImageController@update');
});
