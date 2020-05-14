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

// Super Admin Permissions  
// Category Trashed and Restore
Route::get('/trashedCats' , 'CategoryController@trashed') ; 
Route::get('/categories/restore/{id}' , 'CategoryController@restore');

// User Trashed and Restore
Route::get('/trashedUsers' , 'UserController@trashed') ; 
Route::get('/users/restore/{id}' , 'UserController@restore');

// Post Trashed and Restore
Route::get('/trashedPosts' , 'PostController@trashed') ; 
Route::get('/posts/restore/{id}' , 'PostController@restore');

// Comment Trashed and Restore
Route::get('/trashedComments' , 'CommentController@trashed') ; 
Route::get('/comments/restore/{id}' ,'CommentController@restore');



