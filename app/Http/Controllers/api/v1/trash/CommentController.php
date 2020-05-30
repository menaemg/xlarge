<?php

namespace App\Http\Controllers\Api\V1\trash;

use App\Comment;
use App\Replay;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    // Super Admin Functions
    public function destory($id){
        $comment = Comment::withTrashed()->findOrFail($id);

        if ($comment->trashed())
        {
            $comment->forceDelete();
            $status = 1;
            $message="Comment Deleted successfully";
            return jsonResponse($status, $message , $comment);
        }
    }

    public function trashed()
    {
        $trashed = Comment::onlyTrashed()->get();
        return response()->json($trashed);
    }

    public function restore($id)
    {

        $comment = Comment::onlyTrashed()->findOrFail($id);

        $post = Post::find($comment->post_id);

        $user = User::find($comment->user_id);

        if (!$post) {
            $status = 0;
            $message = 'post for this comment not exist' ;
            return jsonResponse($status, $message , $replay );
        }

        if (!$user){
            $status = 0;
            $message = 'user for this comment not exist' ;
            return jsonResponse($status, $message , $replay );
        }

        //restore replies for this comment
        $restore  = $comment->restore();

        if ($restore){
            $replies = Replay::onlyTrashed()->where('comment_id' , $comment->id)->get();
            Replay::onlyTrashed()->where('comment_id' , $comment->id)->restore();
        }

        $comment->replies = $replies;

        $status = 1;
        $message = 'Comment Restored Successfully' ;
        return jsonResponse($status, $message , $comment );
    }
}
