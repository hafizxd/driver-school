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
    App::setLocale("id");
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/child/{id}', 'ChildController@info');

    Route::get('/user', 'UserController@index');
    Route::get('/user/{id}/block', 'UserController@block');
    Route::get('/user/{id}', 'UserController@infoWeb')->name('userinfo');
    Route::post('/user/update', 'UserController@update');
    Route::get('/user/search/{name}', 'UserController@nameSearch');

    Route::get('/driver', 'DriverController@index');
    Route::get('/driver/{id}/accept', 'DriverController@accept');
    Route::get('/driver/{id}/decline', 'DriverController@decline');
    Route::get('/driver/{id}/block', 'DriverController@block');
    Route::get('/driver/{id}', 'DriverController@infoWeb');
    Route::post('/driver/update', 'DriverController@updateWeb');

    Route::get('/order', 'OrderController@index')->name('order');
    Route::get('/order/{id}', 'OrderController@show');
    Route::post('/order/update', 'OrderController@update');
    Route::get('/order/search/{name}', 'OrderController@orderSearch');
});

Route::get('/change-password', 'PasswordController@reset');
Route::post('/change-password/edit', 'PasswordController@update');

Route::post('/validate/driver', 'DriverController@validateDriver');
