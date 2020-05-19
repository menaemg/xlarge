<?php

namespace App\Http\Controllers;

use App\Replay;
use Illuminate\Http\Request;
use Validator;

class ReplayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Replay::all());
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
            'content' => 'required|max:1000',
            'comment_id' => 'required|exists:comments,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $replay = Replay::create( $request->all());

        $status = 1;
        $message = 'Replay created successfully';

        return jsonResponse($status, $message , $replay );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function show(Replay $replay)
    {
        return response()->json($replay);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function edit(Replay $replay)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Replay $replay)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255',
            'comment_id' => 'required|exists:comments,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $replay->update( $request->all());

        $status = 1;
        $message = 'Replay update successfully';

        return jsonResponse( $status, $message , $replay );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Replay  $replay
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $replay = Replay::withTrashed()->findOrFail($id);
        if($replay->trashed())
        {
            $replay->forceDelete();
            $status = 1;
            $message = 'Replay Deleted Successfully' ;
            return jsonResponse($status, $message , $replay );
        }
        else
        {
            $replay->delete();
            $status = 1;
            $message = 'Replay Trashed Successfully' ;
            return jsonResponse($status, $message , $replay );
        }
    }

    public function trashed()
    {
        $trashed = Replay::onlyTrashed()->get();
        return response()->json($trashed);
    }

    public function restore($id)
    {
        $replay = Replay::onlyTrashed()->findOrFail($id)->restore();
        $status = 1;
        $message = 'Replay Restored Successfully' ;
        return jsonResponse($status, $message , $replay );
    }
}
