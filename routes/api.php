<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/users' , 'UserController');
Route::resource('/posts' , 'PostController');
Route::resource('/categories' , 'CategoryController');
Route::resource('/comments' , 'CommentController');

//routes to delete
//Route::get('users/delete/{user}' , 'UserController@destroy');
//Route::get('posts/delete/{post}' , 'PostController@destroy');
//Route::get('categories/delete/{category}' , 'CategoryController@destroy');
//Route::get('comments/delete/{comment}' , 'CommentController@destroy');