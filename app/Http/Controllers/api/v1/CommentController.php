<?php

namespace App\Http\Controllers\Api\V1;

use App\Comment;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    // Get /comments
    // show all comments data
    public function index()
    {
        return response()->json(Comment::all());
    }

    // Post /comments/create
    // Create new comments
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:1000',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $comment = Comment::create( $request->all());


        // if commnet creat successfully
        $status = 1;
        $message = 'comments created successfully';

        return jsonResponse($status, $message , $comment );
    }

    // Git  /comments/show/{comment}
    // show one comment
    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    // Get /comment/edite/{commnet}
    // show all comment data
    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $comment->update( $request->all());

        // if comment update successfully
        $status = 1;
        $message = 'comments update successfully';

        return jsonResponse($status, $message , $comment );
    }


    public function destroy($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        if($comment->trashed())
        {
            $comment->forceDelete();
            $status = 1;
            $message = 'Comment Deleted Successfully' ;
            return jsonResponse($status, $message , $comment );
        }
        else
        {
            $comment->delete();
            $status = 1;
            $message = 'Comment Trashed Successfully' ;
            return jsonResponse($status, $message , $comment );
        }
    }

    public function trashed()
    {
        $trashed = Comment::onlyTrashed()->get();
        return response()->json($trashed);
    }

    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id)->restore();
        $status = 1;
        $message = 'Comment Restored Successfully' ;
        return jsonResponse($status, $message , $comment );
    }
}
