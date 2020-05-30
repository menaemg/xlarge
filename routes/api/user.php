<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// likes
// posts liked by user
Route::get('/like/posts' , 'Api\V1\user\LikeController@index');
// like or unlike post
Route::post('/like/add/{post}' , 'Api\V1\user\LikeController@store');
// check if user like this post
Route::get('/like/status/{post}' , 'Api\V1\user\LikeController@show');

// comments
// show user comments
Route::get('/comments' , 'Api\V1\user\CommentController@index');
// create comment
Route::post('/comments/create' , 'Api\V1\user\CommentController@store');
// edit comment
Route::post('/comments/edit/{comment}' , 'Api\V1\user\CommentController@update');
// delete comment
Route::post('/comments/delete/{comment}' , 'Api\V1\user\CommentController@destroy');


// replies
// show user replies
Route::get('/replies' , 'Api\V1\user\ReplayController@index');
// create comment
Route::post('/replies/create' , 'Api\V1\user\ReplayController@store');
// edit comment
Route::post('/replies/edit/{replay}' , 'Api\V1\user\ReplayController@update');
// delete comment
Route::post('/replies/delete/{replay}' , 'Api\V1\user\ReplayController@destroy');


// Profile
// show profile
Route::get('/profile/me' , 'Api\V1\user\ProfileController@show');
// edit profile
Route::post('/profile/edit' , 'Api\V1\user\ProfileController@update');
// logout
Route::post('/logout' , 'Api\V1\user\ProfileController@logout');
