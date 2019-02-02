<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//User
Route::post('/user/register', 'UserController@store');
Route::post('/user/login', 'UserController@login');
Route::post('/user/complete', 'UserController@complete');
Route::post('/user/reset', 'UserController@resetpassword');
Route::post('/user', 'UserController@info');


//Driver
Route::post('/driver/register', 'DriverController@store');
Route::post('/driver/login', 'DriverController@login');
Route::post('/driver/complete', 'DriverController@complete');
Route::post('/driver', 'DriverController@info');
Route::get('/driver', 'DriverController@allDriver');

Route::post('/order', 'OrderController@order');
