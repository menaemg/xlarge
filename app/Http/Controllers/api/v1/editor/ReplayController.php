<?php

namespace App\Http\Controllers\Api\V1\editor;

use App\Replay;
use App\Comment;
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
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        // set default value to Auth usr
        if ($request->user_id == null){
            $user_id = Auth('api')->user()->id;
        } else {
            $user_id = $request->user_id;
        }

        $replay = Replay::create([
            'content' =>$request->content,
            'comment_id' =>$request->comment_id,
            'user_id' =>$user_id,
        ]);

        $status = 1;
        $message = 'Replay created successfully';

        return jsonResponse($status, $message , $replay );
    }

    // Git /replays/show/{replay}
    // show one replay
    public function show($replay)
    {
        $replay = Replay::findOrFail($replay);

        $comment = Comment::findOrFail($replay->comment_id);
        $commentData = [];

        $commentData[] = [
            'id' => $replay['id'],
            'content' => $replay['content'],
            'user_id' => $replay['user_id'],
            'comment_id' => $replay['comment_id'],
            'created_at' => date('Y-m-d H:i' , strtotime($replay['created_at'])),
            'updated_at' => date('Y-m-d H:i' , strtotime($replay['updated_at'])),
            'comment' => $comment
        ];

        return response()->json($commentData);
    }

    // Post /replays/edit/{replay}
    // edit one replay
    public function update(Request $request,$replay)
    {
        $replay = Replay::FindOrFail($replay);

        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255',
            'comment_id' => 'required|exists:comments,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        // set default value to Auth usr
        if ($request->user_id == null){
            $user_id = Auth('api')->user()->id;
        } else {
            $user_id = $request->user_id;
        }

        $replay->update([
            'content' =>$request->content,
            'comment_id' =>$request->comment_id,
            'user_id' =>$user_id,
        ]);

        $status = 1;
        $message = 'Replay update successfully';

        return jsonResponse( $status, $message , $replay );
    }

    // Post /delete/{replay}
    // delete one replay
    public function destroy($id)
    {
        $replay = Replay::withTrashed()->findOrFail($id);
        if(!$replay->trashed())
        {
            $replay->delete();
            $status = 1;
            $message="replay Trashed successfully";
            return jsonResponse($status, $message , $replay);
        } else {
            $status = 0;
            $message="you can't delete this replay";
            return jsonResponse($status, $message , $replay);
        }
    }
}
