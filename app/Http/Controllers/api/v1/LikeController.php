<?php

namespace App\Http\Controllers\Api\V1;

use App\Like;
use DB;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // count likes in one post
    public function postLikes(Request $request , $id){

        $likes = DB::table('likes')
        ->where('post_id', '=', $id)
        ->get();
        $likes = $likes->count();

        return jsonResponse(1 , 'likes', $likes);

    }
    // like or unlike post
    public function postLike(Request $request ,$id){

        $likepost = Like::where([
            'user_id' =>  $request->user_id ,
            'post_id' =>  $id
        ]);

        $likes = DB::table('likes')
                ->where('post_id', '=', $id)
                ->where('user_id', '=', $request->user_id)
                ->get();


        // like if user don't like this post yet
        if ($likes->all() == []){

            $like = Like::create([

                'user_id' => $request->user_id,
                'post_id' => $id

            ]);

            return jsonResponse(1 , 'like', $like);

        // unlike if user like this post
        } else {

            $like = Like::find($likes->first()->id)->delete();
            return jsonResponse(1 , 'unlike', $likes);

        }
    }

    // check if user like this post or not
    public function likeStatus(Request $request ,$id){

        $likepost = Like::where([
            'user_id' =>  $request->user_id ,
            'post_id' =>  $id
        ]);

        $likes = DB::table('likes')
                ->where('post_id', '=', $id)
                ->where('user_id', '=', $request->user_id)
                ->get();

        if ($likes->count()){
            return jsonResponse(1 , 'user like this post' , 1);
        } else {
            return jsonResponse(0 , 'user unlike this post' , 0);
        };
    }
}
