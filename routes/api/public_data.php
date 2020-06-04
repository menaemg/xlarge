<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// posts
Route::get('/posts' , 'Api\V1\public_data\PostController@index');
// post
Route::get('/posts/show/{post}' , 'Api\V1\public_data\PostController@show');

// categories
Route::get('/categories' , 'Api\V1\public_data\CategoryController@index');
// category
Route::get('/categories/show/{category}' , 'Api\V1\public_data\CategoryController@show');

// users
Route::get('/users' , 'Api\V1\public_data\UserController@index');
// user
Route::get('/users/show/{id}' , 'Api\V1\public_data\UserController@show');
