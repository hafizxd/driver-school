<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function(){
  return redirect('/user');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/user', 'UserController@index')->name('user');
    Route::put('/user/{id}/edit', 'UserController@update');
    Route::get('/user/{id}', 'UserController@show');
});
