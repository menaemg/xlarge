<?php

namespace App\Http\Controllers\Api\V1\trash;

use App\Replay;
use App\Comment;
use App\User;
use Illuminate\Http\Request;
use Validator;

class ReplayController extends Controller
{
    // Super Admin Functions
    public function destory($id){
        $replay = Replay::withTrashed()->findOrFail($id);
        if ($replay->trashed())
        {
            $replay->forceDelete();
            $status = 1;
            $message="Replay Deleted successfully";
            return jsonResponse($status, $message , $replay);
        }
    }

    public function trashed()
    {
        $trashed = Replay::onlyTrashed()->get();
        return response()->json($trashed);
    }

    public function restore($id)
    {
        $replay = Replay::onlyTrashed()->findOrFail($id);

        $comment = Comment::find($replay->comment_id);

        $user = User::find($replay->user_id);

        if (!$comment) {
            $status = 0;
            $message = 'comment for this replay not exist' ;
            return jsonResponse($status, $message , $replay );
        }

        if (!$user){
            $status = 0;
            $message = 'user for this replay not exist' ;
            return jsonResponse($status, $message , $replay );
        }

        $replay = $replay->restore();

        $status = 1;
        $message = 'Replay Restored Successfully' ;
        return jsonResponse($status, $message , $replay );

    }
}
