<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// register
Route::post('/register' , 'Api\V1\auth\AuthController@register');

// login
Route::post('/login' , 'Api\V1\auth\AuthController@login');

// forgot password
Route::post('/password/forgot' , 'Api\V1\auth\ForgotPasswordController@sendResetLinkEmail');

// reset password
Route::post('/password/reset' , 'Api\V1\auth\ResetPasswordController@reset');
