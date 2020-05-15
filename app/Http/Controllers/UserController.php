<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users',
            'password' =>'required', 'min:6', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/', 'confirmed',
            'image' => 'required|image',
            'rule' => 'in:0,1,2,3',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $request->image->store('images', 'public'),
            'rule' => $request->rule,
        ]);

        $status = 1;
        $message = 'user created successful';

        return jsonResponse($status, $message , $user );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required' ,'email', \Illuminate\Validation\Rule::unique('users')->ignore($user) ,
            'password' =>'required', 'min:6', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/', 'confirmed',
            'image' => 'required|image',
            'rule' => 'in:0,1,2,3',
        ]);

        if ($validator->fails()) {
            //$status = 0;
            return jsonResponse(0, $validator->messages() , $request->all());
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $request->image->store('images', 'public'),
            'rule' => $request->rule,
        ]);

        $status = 1;
        $message = 'user updated successful';

        return jsonResponse($status, $message , $user );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->trashed())
        {
            $user->forceDelete();
            $status = 1;
            $message="User Deleted successfully";
            return jsonResponse($status, $message , $user);
        }
        else
        {
            $user->delete();
            $status = 1;
            $message="User Deleted successfully";
            return jsonResponse($status, $message , $user);
        }
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return response()->json($users);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id)->restore();

        $status = 1;
        $message="User Restored successfully";
        return jsonResponse($status, $message , $user);
    }
}
