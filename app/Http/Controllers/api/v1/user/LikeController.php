<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Like;
use App\Post;
use DB;
use Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // count likes in one post
    public function index(){
        $id = auth('api')->user()->id;
        $likes = DB::table('likes')
            ->where('user_id', '=', $id)
        ->get();
        $likesCount = $likes->count();
        $likes = $likes->toArray();
        $posts = [];
        foreach ($likes as $like){
            $post = Post::findOrFail($like->post_id);
            $posts[] = $post;
        }

        $status = 1;
        $message = $likesCount . ' likes';
        return jsonResponse($status , $message, $posts);

    }
    // like or unlike post
    public function store($id){
        $user = auth('api')->user()->id;
        $likepost = Like::where([
            'user_id' =>  $user ,
            'post_id' =>  $id
        ]);

        $likes = DB::table('likes')
                ->where('post_id', '=', $id)
                ->where('user_id', '=', $user)
                ->get();


        // like if user don't like this post yet
        if ($likes->all() == []){

            $like = Like::create([

                'user_id' => $user,
                'post_id' => $id

            ]);
            $status = 1;
            return jsonResponse($status , 'like' , 1);

        // unlike if user like this post
        } else {
            $status = 1;
            $like = Like::find($likes->first()->id);
            $unlike = Like::find($likes->first()->id)->delete();

            return jsonResponse($status , 'unlike' , 0);
        }
    }

    // check if user like this post or not
    public function show($id){
        $user = Auth::id();
        $likepost = Like::where([
            'user_id' =>  $user ,
            'post_id' =>  $id
        ]);

        $likes = DB::table('likes')
                ->where('post_id', '=', $id)
                ->where('user_id', '=', $user)
                ->get();

        if ($likes->count()){
            $status = 1;
            return jsonResponse($status , 'like' , 1);
        } else {
            $status = 1;
            return jsonResponse($status , 'unlike' , 0);
        };
    }
}
