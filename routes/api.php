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
Route::get('/user/login', 'UserController@login');


//Driver
Route::post('/driver/register', 'DriverController@store');
Route::get('/driver/login', 'DriverController@login');
