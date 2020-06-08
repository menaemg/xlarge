<?php

namespace App\Http\Controllers\api\v1\public_data;

use App\Category;
use App\Post;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()->toArray();

        $usersData = [];

        foreach ($users as $user){

            $posts = Post::where('user_id' ,  $user['id'])->get()->toArray();
            $views = 0;
            $likes = 0;

            foreach ( $posts as $post){

                $postlikes = DB::table('likes')
                    ->where('post_id', '=', $post['id'])
                    ->get();

                $postlikes = $postlikes->count();

                $views = $views + $post['views'];
                $likes = $likes + $postlikes;

            }
            $usersData[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'image' => $user['image'],
                'created_at' =>  date('Y-m-d H:i' , strtotime($user['created_at'])),
                'views'  => $views,
                'likes'  => $likes,
            ];
        }
        return response()->json($usersData);
    }

    public function show($id){

        $user = User::findOrFail($id)->toArray();

        $posts = Post::where('user_id' ,  $user['id'])->get();
        $user_views = 0;
        $user_likes = 0;



        foreach ( $posts as $post){
            $postlikes = DB::table('likes')
            ->where('post_id', '=', $post['id'])
            ->get();
            $postlikes = $postlikes->count();

            $postsData[] = [
                'id' => $post['id'],
                'title' => $post['title'],
                'content' => $post['content'],
                'image' => $post['image'],
                'likes' =>  $postlikes,
                'views' =>  $post['views'],
                'created_at' =>  date('Y-m-d H:i' , strtotime($post['created_at'])),
            ];
            $user_views = $user_views + $post['views'];
            $user_likes = $user_likes + $postlikes;
        }

        $userData[] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'image' => $user['image'],
            'created_at' =>  date('Y-m-d H:i' , strtotime($user['created_at'])),
            'views'  => $user_views,
            'likes'  => $user_likes,
            'posts'  => $postsData
        ];

    return response()->json($userData);
    }
}
