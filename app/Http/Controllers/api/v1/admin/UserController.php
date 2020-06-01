<?php

namespace App\Http\Controllers\Api\V1\admin;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Auth;
use Hash;
use Storage;


class UserController extends Controller
{
    // Get /users
    // show all user data
    public function index()
    {
        return response()->json(User::all());
    }



    // Post /users/create
    // Create new user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' =>'required', 'min:6', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/', 'confirmed',
            'image' => 'nullable|image',
            'rule' => 'nullable|in:0,1,2,3',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }


        // set default value for rule
        if ($request->rule){
            $rule = $request->rule;
        } else {
            $rule = 1;
        }

        // store user image in storage
        if ($request->image){
            $imageName = '/storage/' . $request->image->store('images', 'public');
        // set default user image
        } else {
            $url = 'https://api.adorable.io/avatars/240/'. rand(1,1000);
            $contents = file_get_contents($url);
            $image =  md5($contents) . '.png';
            $imageName = 'storage/images/' . md5($contents) . '.png';
            Storage::disk('images')->put( $image , file_get_contents($url));
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => 'http://127.0.0.1:8000///' . $imageName,
            'rule' => $rule,
        ]);

        // if user created successfully
        $status = 1;
        $message = 'user created successful';

        return jsonResponse($status, $message , $user );
    }



    // Get /users/show/{user}
    // show user info
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }


    // Post /users/edit/{user}
    // edit the user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users'. ($user->id ? ",id,$user->id" : ''),
            'password' =>'nullable|min:6|confirmed',
            'image' => 'nullable|image',
            'rule' => 'nullable|in:0,1,2,3',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        // set default value for rule
        if ($request->rule){
            $rule = $request->rule;
        } else {
            $rule = 1;
        }

        // set default value to Auth usr
        if ($request->password == null){
            $password = $user->password;
        } else {
            $password = Hash::make($request->password);
        }

        // store user image in storage
        if ($request->image){
            $imageName = 'http://127.0.0.1:8000///storage/' . $request->image->store('images', 'public');
        // use old image
        } else {
            $imageName = $user->image;
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
            'image' =>  $imageName,
            'rule' => $rule,
        ]);


        // if user update successfully
        $status = 1;
        $message = 'user updated successful';

        return jsonResponse($status, $message , $user );
    }


    // Post /users/delete/{user}
    // delete users
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if (!$user->trashed())
        {

            if (Auth::user()->id == $id)
            {

                $status = 0;
                $message="you can't delete your profile from here";
                return jsonResponse($status, $message , $user);

            }

            $user->delete();
            $status = 1;
            $message="User Trashed successfully";
            return jsonResponse($status, $message , $user);

        } else {

            $status = 0;
            $message="you can't delete this user";
            return jsonResponse($status, $message , $user);

        }
    }
}
