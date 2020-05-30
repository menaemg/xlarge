<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users' , 'Api\V1\admin\UserController@index');
Route::get('/users/show/{user}' , 'Api\V1\admin\UserController@show');
Route::post('/users/create' , 'Api\V1\admin\UserController@store');
Route::post('/users/edit/{user}' , 'Api\V1\admin\UserController@update');
Route::post('/users/delete/{user}' , 'Api\V1\admin\UserController@destroy');
