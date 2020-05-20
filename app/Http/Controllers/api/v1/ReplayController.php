<?php

namespace App\Http\Controllers\Api\V1;

use App\Replay;
use Illuminate\Http\Request;
use Validator;

class ReplayController extends Controller
{
    // Get /replays
    // show all replays data
    public function index()
    {
        return response()->json(Replay::all());
    }

    // Post /replays/create
    // create one replay
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

    // Git /replays/show/{replay}
    // show one replay
    public function show(Replay $replay)
    {
        return response()->json($replay);
    }

    // Post /replays/edit/{replay}
    // edit one replay
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

    // Post /delete/{replay}
    // delete one replay
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
