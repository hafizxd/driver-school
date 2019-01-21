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

    Route::get('/pelanggan', 'UserController@index');
    Route::get('/pelanggan/{id}', 'UserController@show');

    Route::get('/supir', 'DriverController@index');
    Route::get('/supir/{id}', 'DriverController@show');
});
