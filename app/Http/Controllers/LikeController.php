<?php

namespace App\Http\Controllers;

use App\Like;
use DB;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function postLikes($id){

        $likes = DB::table('likes')
        ->where('post_id', '=', $id)
        ->get();
        $likes = $likes->count();

        return jsonResponse(1 , 'likes', $likes);

    }
    public function postLike(Request $request ,$id){

        $likepost = Like::where([
            'user_id' =>  $request->user_id ,
            'post_id' =>  $request->$id
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

    public function likeStatus(Request $request ,$id){

        $likepost = Like::where([
            'user_id' =>  $request->user_id ,
            'post_id' =>  $request->$id
        ]);

        $likes = DB::table('likes')
                ->where('post_id', '=', $id)
                ->where('user_id', '=', $request->user_id)
                ->get();

        if ($likes->count()){
            return jsonResponse(1 , 'user like this post');
        } else {
            return jsonResponse(0 , 'user unlike this post');
        };
    }
}
