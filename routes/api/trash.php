<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// user trash
Route::get('/users' , 'Api\V1\trash\UserController@trashed') ;
Route::post('/users/restore/{user}' , 'Api\V1\trash\UserController@restore');
Route::post('/users/delete/{user}' , 'Api\V1\trash\UserController@destory');

// posts trash
Route::get('/posts' , 'Api\V1\trash\PostController@trashed') ;
Route::post('/posts/restore/{post}' , 'Api\V1\trash\PostController@restore');
Route::post('/posts/delete/{post}' , 'Api\V1\trash\PostController@destory');

// categories trash
Route::get('/categories' , 'Api\V1\trash\CategoryController@trashed') ;
Route::post('/categories/restore/{category}' , 'Api\V1\trash\CategoryController@restore');
Route::post('/categories/delete/{category}' , 'Api\V1\trash\CategoryController@destory');

// comments trash
Route::get('/comments' , 'Api\V1\trash\CommentController@trashed') ;
Route::post('/comments/restore/{comment}' , 'Api\V1\trash\CommentController@restore');
Route::post('/comments/delete/{comment}' , 'Api\V1\trash\CommentController@destory');

// replies trash
Route::get('/replies' , 'Api\V1\trash\ReplayController@trashed') ;
Route::post('/replies/restore/{replay}' , 'Api\V1\trash\ReplayController@restore');
Route::post('/replies/delete/{replay}' , 'Api\V1\trash\ReplayController@destory');
