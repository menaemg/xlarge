<?php

namespace App\Http\Controllers\api\v1\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Hash;
use Auth;
use Storage;

class ProfileController extends Controller
{
    public function show(){
        $user = Auth('api')->user();

        return response()->json($user);
    }

    public function update(Request $request){
        $user = Auth('api')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' =>  'required|email|unique:users'. ($user->id ? ",id,$user->id" : ''),
            'password' =>'required|min:6|confirmed',
            'image' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }


        // store user image in storage
        if ($request->image){
            $imageName = 'http://127.0.0.1:8000///storage/' . $request->image->store('images', 'public');
        // use old image if request is null
        } else {
            $imageName = $user->image;
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' =>  $imageName,
        ]);


        // if user update successfully
        $status = 1;
        $message = 'user updated successful';

        return jsonResponse($status, $message , $user );
    }

    public function logout(Request $request)
    {
        $logout = Auth::user()->token()->revoke();

        if ($logout){
            $status = 1;
            $message = 'Successfully logged out';
            return jsonResponse($status, $message );
        }
    }
}
