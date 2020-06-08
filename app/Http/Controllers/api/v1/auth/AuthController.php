<?php

namespace App\Http\Controllers\Api\V1\auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Auth;
use Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|string|confirmed'
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->email);
        };

        // $url = 'https://api.adorable.io/avatars/240/'. rand(1,1000);
        // $contents = file_get_contents($url);
        // $image =  md5($contents) . '.png';
        // $imageName = 'storage/images/' . md5($contents) . '.png';
        // Storage::disk('images')->put( $image , file_get_contents($url));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => 'http://127.0.0.1:8000///storage/images/users/avatar.png',
            'rule' => 1,
        ]);

        // if user register successfully
        $status = 1;
        $message = 'user register successfully';
        $accessToken = $user->createToken('accessToken')->accessToken;

        return jsonResponse($status, $message , $user , $accessToken);
    }

    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!$login) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->email);
        };

        if ( !auth()->attempt($login)){
            $status = 0;
            return jsonResponse($status , 'invalid email or password' , $request->email);
        }

        $status = 1;
        $message = 'user login successfully';

        $accessToken = auth()->user()->createToken('accessToken')->accessToken;

        return jsonResponse($status, $message , auth()->user() , $accessToken);
    }
}
