<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth as Admin auth::admin->rule > 2
// users routes
Route::get('/users' , 'Api\V1\UserController@index');
Route::get('/users/show/{user}' , 'Api\V1\UserController@show');
Route::post('/users/create' , 'Api\V1\UserController@store');
Route::post('/users/edit/{user}' , 'Api\V1\UserController@update');
Route::post('/users/delete/{user}' , 'Api\V1\UserController@destroy');
// Trashed and Restore
Route::get('/users/trash' , 'Api\V1\UserController@trashed') ;
Route::post('/users/restore/{user}' , 'Api\V1\UserController@restore');
##########################################################################
##########################################################################
##########################################################################
// Auth as Admin & Editor auth::admin->rule > 1
// posts routes
Route::get('/posts' , 'Api\V1\PostController@index');
Route::get('/posts/show/{post}' , 'Api\V1\PostController@show');
Route::post('/posts/create' , 'Api\V1\PostController@store');
Route::post('/posts/edit/{post}' , 'Api\V1\PostController@update');
Route::post('/posts/delete/{post}' , 'Api\V1\PostController@destroy');
// Trashed and Restore
Route::get('/posts/trash' , 'Api\V1\PostController@trashed') ;
Route::post('/posts/restore/{post}' , 'Api\V1\PostController@restore');

// posts categories
Route::get('/categories' , 'Api\V1\CategoryController@index');
Route::get('/categories/show/{category}' , 'Api\V1\CategoryController@show');
Route::post('/categories/create' , 'Api\V1\CategoryController@store');
Route::post('/categories/edit/{category}' , 'Api\V1\CategoryController@update');
Route::post('/categories/delete/{category}' , 'Api\V1\CategoryController@destroy');
// Trashed and Restore
Route::get('/categories/trash' , 'Api\V1\CategoryController@trashed') ;
Route::post('/categories/restore/{category}' , 'Api\V1\CategoryController@restore');

// posts comments
Route::get('/comments' , 'Api\V1\CommentController@index');
Route::get('/comments/show/{comment}' , 'Api\V1\CommentController@show');
Route::post('/comments/create' , 'Api\V1\CommentController@store');
Route::post('/comments/edit/{comment}' , 'Api\V1\CommentController@update');
Route::post('/comments/delete/{comment}' , 'Api\V1\CommentController@destroy');
// Trashed and Restore
Route::get('/comments/trash' , 'Api\V1\CommentController@trashed') ;
Route::post('/comments/restore/{comment}' , 'Api\V1\CommentController@restore');

// posts replays
Route::get('/replays' , 'Api\V1\ReplayController@index');
Route::get('/replays/show/{replay}' , 'Api\V1\ReplayController@show');
Route::post('/replays/create' , 'Api\V1\ReplayController@store');
Route::post('/replays/edit/{replay}' , 'Api\V1\ReplayController@update');
Route::post('/replays/delete/{replay}' , 'Api\V1\ReplayController@destroy');
// Trashed and Restore
Route::get('/replays/trash' , 'Api\V1\ReplayController@trashed') ;
Route::post('/replays/restore/{replay}' , 'Api\V1\ReplayController@restore');
##########################################################################
##########################################################################
##########################################################################
// Auth as user auth::user->rule > 0
// comment
// my profile show and edit
Route::post('/comments/create' , 'Api\V1\ReplayController@store');
// replay
Route::post('/replays/create' , 'Api\V1\CommentController@store');
// like or unlike post
Route::post('/like/add/{post}' , 'Api\V1\LikeController@postLike') ;
// check if user like this post
Route::get('/like/status/{post}' , 'Api\V1\LikeController@likeStatus') ;
#########################################################################
#########################################################################
#########################################################################

// Public show
// post => comments
// comment => replies
// category => posts
// post => views
// public profiles
// post => likes
Route::get('/like/count/{post}' , 'Api\V1\LikeController@postLikes') ;
