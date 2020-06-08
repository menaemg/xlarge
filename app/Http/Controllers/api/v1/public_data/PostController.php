<?php

namespace App\Http\Controllers\Api\V1\public_data;

use App\Post;
use App\User;
use App\Category;
use App\Comment;
use App\Replay;
use App\Auth;
use Illuminate\Http\Request;
use Validator;
use DB;

class PostController extends Controller
{


    public function index()
    {

        $posts = Post::where('status' , 1)->get();
        $posts = $posts->toArray();

        $postsData = [];

        foreach ($posts as $post){

            // check if user like this post
            $user_like_status = 0;
            if (Auth('api')->id()){
                $auth_user_id = Auth('api')->id();

                    $like_status = DB::table('likes')
                    ->where('post_id', '=', $post['id'])
                    ->where('user_id', '=', $auth_user_id)
                    ->get();

                    if ($like_status->count()){
                        $user_like_status = 1;
                    }
            }

            // find how publish this post
            $user = User::findOrFail($post['user_id']);

            // get likes for this post
            $likes = DB::table('likes')
                ->where('post_id', '=', $post['id'])
                ->get();
            $likes = $likes->count();

            // get category for this post
            $category_name = Category::find($post['category_id']);


            $postsData[] = [
                'id' => $post['id'],
                'title' => $post['title'],
                'content' => $post['content'],
                'image' => $post['image'],
                'user_id' => $post['user_id'],
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'image' => $user->image,
                ],
                'likes' => $likes,
                'user_like_status' => $user_like_status,
                'views' => $post['views'],
                'category_id' => $post['category_id'],
                'category_name' => $category_name,
                'created_at' =>  date('Y-m-d H:i' , strtotime($post['created_at'])),
                'updated_at' =>  date('Y-m-d H:i' , strtotime($post['updated_at'])),
            ];
        }
        return response()->json($postsData);

    }
    public function show($id) {

        $postview = Post::findOrFail($id);
        // add 1 to post views counter
        $views = $postview->views + 1;

        // update post views
        $postview->update([
            'views' => $views
        ]);


        $post = Post::findOrFail($id);

        $user = User::findOrFail($post['user_id']);

        // get likes for this post
        $likes = DB::table('likes')
            ->where('post_id', '=', $post['id'])
            ->get();
        $likes = $likes->count();

        // check if user like this post
        $user_like_status = 0;
        if (Auth('api')->id()){
            $auth_user_id = Auth('api')->id();

                $like_status = DB::table('likes')
                ->where('post_id', '=', $post['id'])
                ->where('user_id', '=', $auth_user_id)
                ->get();

                if ($like_status->count()){
                    $user_like_status = 1;
                }
        }

        // get category for this post
        $category = Category::find($post['category_id']);
        if ($category == null){
            $category = null;
        } else {
            $category = [
                'category_id' => $category->id,
                'category_name' => $category->name,
            ];
        }

        // get comments and replies for this post
        $comments = Comment::where('post_id' , $id)->get();
        $comments = $comments->toArray();

        $commentsData = [];

        foreach ($comments as $comment){

            $usercomment = User::findOrFail($comment['user_id']);
            $replies = Replay::where('comment_id' , $comment['id'])->get()->toArray();

            $replayData = [];

            foreach ($replies as $replay){
                $userreplay = User::findOrFail($replay['user_id']);
                $replayData[] = [
                    'id' => $replay['id'],
                    'content' => $replay['content'],
                    'content' => $replay['content'],
                    'user' => [
                        'id' => $userreplay->id,
                        'name' => $userreplay->name,
                        'image' => $userreplay->image
                    ],
                    'content' => $replay['content'],
                    'created_at' => $replay['content'],
                ];
            }
            $commentsData[] =[

                'id' => $comment['id'],
                'content' => $comment['content'],
                'user' => [
                    'id' => $usercomment->id,
                    'name' => $usercomment->name,
                    'image' => $usercomment->image,
                ],
                'replay' => $replayData,
                'created_at' => date('Y-m-d H:i' , strtotime($comment['created_at'])),

            ];
        }

        $postData[] = [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'image' => $post->image,
            'likes' => $likes,
            'user_like_status' => $user_like_status,
            'views' => $post->views,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $user->image,
            ],
            'category' => $category,
            'comments' => $commentsData,
            'created_at' =>  date('Y-m-d H:i' , strtotime($post->created_at)),
            'updated_at' =>  date('Y-m-d H:i' , strtotime($post->updated_at)),
        ];
        return response()->json($postData);
    }

    public function postComments($id){

        $comments = Comment::where('post_id' , $id)->get();
        $comments = $comments->toArray();

        $commentsData = [];

        foreach ($comments as $comment){

            $usercomment = User::findOrFail($comment['user_id']);
            $replies = Replay::where('comment_id' , $comment['id'])->get()->toArray();

            $replayData = [];

            foreach ($replies as $replay){
                $userreplay = User::findOrFail($replay['user_id']);
                $replayData[] = [
                    'id' => $replay['id'],
                    'content' => $replay['content'],
                    'content' => $replay['content'],
                    'user' => [
                        'id' => $userreplay->id,
                        'name' => $userreplay->name,
                        'image' => $userreplay->image
                    ],
                    'content' => $replay['content'],
                    'created_at' => $replay['content'],
                ];
            }

            $commentsData[] =[

                'id' => $comment['id'],
                'content' => $comment['content'],
                'user' => [
                    'id' => $usercomment->id,
                    'name' => $usercomment->name,
                    'image' => $usercomment->image,
                ],
                'replay' => $replayData,
                'created_at' => date('Y-m-d H:i' , strtotime($comment['created_at'])),

            ];
        }
        return response()->json($commentsData);
    }

}
