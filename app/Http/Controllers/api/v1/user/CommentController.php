<?php

namespace App\Http\Controllers\Api\v1\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Comment;

class CommentController extends Controller
{
    public function index(){
        $user = Auth('api')->user()->id;
        $comments = Comment::where('user_id', $user)->get();

        $commentsCount = $comments->count();

        $status = 1;
        $message = $commentsCount . ' comments';
        return jsonResponse($status , $message , $comments);
    }

    public function store(Request $request){

        $user = Auth('api')->user()->id;

        $validator = Validator::make($request->all(), [
            'content' => 'required|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id' => $user
        ]);

        // if commnet creat successfully
        $status = 1;
        $message = 'comments created successfully';

        return jsonResponse($status, $message , $comment );
    }

    public function update(Request $request, $comment)
    {

        $user = Auth('api')->user()->id;

        $comment = Comment::findOrFail($comment);

        if ($comment->user_id == $user){
            $validator = Validator::make($request->all(), [
                'content' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                $status = 0;
                return jsonResponse($status, $validator->messages() , $request->all());
            }

            $comment->update([
                'content' => $request->content,
                'user_id' => $user
            ]);

            // if comment update successfully
            $status = 1;
            $message = 'comments update successfully';

            return jsonResponse($status, $message , $comment );
        } else {
            $status = 0;
            $message = 'you can\'t edit this comment';

            return jsonResponse($status, $message);
        }
    }

    public function destroy($id)
    {

        $user = Auth('api')->user()->id;

        $comment = Comment::findOrFail($id);

        if ($comment->user_id == $user){

            $comment = Comment::withTrashed()->findOrFail($id);
            if(!$comment->trashed())
            {
                $comment->delete();


                $status = 1;
                $message="Comment Trashed successfully";
                return jsonResponse($status, $message , $comment);
            } else {
                $status = 0;
                $message="you can't delete this comment";
                return jsonResponse($status, $message , $comment);
            }
        } else {
            $status = 0;
            $message = 'you can\'t delete this comment';

            return jsonResponse($status, $message);
        }
    }
}
