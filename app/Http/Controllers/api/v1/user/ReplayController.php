<?php

namespace App\Http\Controllers\Api\v1\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Replay;

class replayController extends Controller
{
    public function index(){
        $user = Auth('api')->user()->id;
        $replies = Replay::where('user_id', $user)->get();

        $repliesCount = $replies->count();

        $status = 1;
        $message = $repliesCount . ' replies';
        return jsonResponse($status , $message , $replies);
    }

    public function store(Request $request){

        $user = Auth('api')->user()->id;

        $validator = Validator::make($request->all(), [
            'content' => 'required|max:1000',
            'comment_id' => 'required|exists:posts,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $replay = Replay::create([
            'content' => $request->content,
            'comment_id' => $request->comment_id,
            'user_id' => $user
        ]);

        // if commnet creat successfully
        $status = 1;
        $message = 'replies created successfully';

        return jsonResponse($status, $message , $replay );
    }

    public function update(Request $request, $replay)
    {

        $user = Auth('api')->user()->id;

        $replay = Replay::findOrFail($replay);

        if ($replay->user_id == $user){
            $validator = Validator::make($request->all(), [
                'content' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                $status = 0;
                return jsonResponse($status, $validator->messages() , $request->all());
            }

            $replay->update([
                'content' => $request->content,
                'user_id' => $user
            ]);

            // if replay update successfully
            $status = 1;
            $message = 'replies update successfully';

            return jsonResponse($status, $message , $replay );
        } else {
            $status = 0;
            $message = 'you can\'t edit this replay';

            return jsonResponse($status, $message);
        }
    }

    public function destroy($id)
    {

        $user = Auth('api')->user()->id;

        $replay = Replay::findOrFail($id);

        if ($replay->user_id == $user){

            $replay = Replay::withTrashed()->findOrFail($id);
            if(!$replay->trashed())
            {
                $replay->delete();
                $status = 1;
                $message="Replay Trashed successfully";
                return jsonResponse($status, $message , $replay);
            } else {
                $status = 0;
                $message="you can't delete this replay";
                return jsonResponse($status, $message , $replay);
            }
        } else {
            $status = 0;
            $message = 'you can\'t delete this replay';

            return jsonResponse($status, $message);
        }
    }
}
