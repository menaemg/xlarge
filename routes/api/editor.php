<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// posts
Route::get('/posts' , 'Api\V1\editor\PostController@index');
Route::get('/posts/show/{post}' , 'Api\V1\editor\PostController@show');
Route::post('/posts/create' , 'Api\V1\editor\PostController@store');
Route::put('/posts/edit/{post}' , 'Api\V1\editor\PostController@update');
Route::delete('/posts/delete/{post}' , 'Api\V1\editor\PostController@destroy');

// categories
Route::get('/categories' , 'Api\V1\editor\CategoryController@index');
Route::get('/categories/show/{category}' , 'Api\V1\editor\CategoryController@show');
Route::post('/categories/create' , 'Api\V1\editor\CategoryController@store');
Route::put('/categories/edit/{category}' , 'Api\V1\editor\CategoryController@update');
Route::delete('/categories/delete/{category}' , 'Api\V1\editor\CategoryController@destroy');

// comments
Route::get('/comments' , 'Api\V1\editor\CommentController@index');
Route::get('/comments/show/{comment}' , 'Api\V1\editor\CommentController@show');
Route::post('/comments/create' , 'Api\V1\editor\CommentController@store');
Route::put('/comments/edit/{comment}' , 'Api\V1\editor\CommentController@update');
Route::delete('/comments/delete/{comment}' , 'Api\V1\editor\CommentController@destroy');

// replies
Route::get('/replies' , 'Api\V1\editor\ReplayController@index');
Route::get('/replies/show/{replay}' , 'Api\V1\editor\ReplayController@show');
Route::post('/replies/create' , 'Api\V1\editor\ReplayController@store');
Route::put('/replies/edit/{replay}' , 'Api\V1\editor\ReplayController@update');
Route::delete('/replies/delete/{replay}' , 'Api\V1\editor\ReplayController@destroy');
