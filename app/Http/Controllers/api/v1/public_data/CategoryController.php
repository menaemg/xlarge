<?php

namespace App\Http\Controllers\api\v1\public_data;

use App\Category;
use App\Post;
use App\User;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('subfrom' , null)->get();
        $categories = $categories->toArray();

        $categoriesData = [];

        foreach ($categories as $category){

            $subcats = Category::where('subfrom' , $category['id'])->get();
            $subcats = $subcats->toArray();
            $subcatData = [];

            foreach ($subcats as $subcat){
                $subcatData[] = [
                    'id' => $subcat['id'],
                    'name' => $subcat['name'],
                    'created_at' =>  date('Y-m-d H:i' , strtotime($subcat['created_at'])),
                ];
            }
            $categoriesData[] = [
                'id' => $category['id'],
                'name' => $category['name'],
                'created_at' =>  date('Y-m-d H:i' , strtotime($category['created_at'])),
                'sub_categories' => $subcatData,

            ];
        }
        return response()->json($categoriesData);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        $subcats = Category::where('subfrom' , $category->id)->get();
        $subcats = $subcats->toArray();
        $subcatData = [];

        foreach ($subcats as $subcat){
            $subcatData[] = [
                'id' => $subcat['id'],
                'name' => $subcat['name'],
                'created_at' =>  date('Y-m-d H:i' , strtotime($subcat['created_at'])),
            ];
        }


        $posts = Post::where('category_id' , $category['id'])->get();
        $posts = $posts->toArray();

        $postsData = [];


        foreach ($posts as $post){

            // find how publish this post
            $user = User::findOrFail($post['user_id']);

            // get likes for this post
            $likes = DB::table('likes')
                ->where('post_id', '=', $post['id'])
                ->get();
            $likes = $likes->count();

            // get category for this post
            $category = Category::findOrFail($post['category_id']);

            $postsData[] = [
                'id' => $post['id'],
                'title' => $post['title'],
                'content' => $post['content'],
                'image' => $post['image'],
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'image' => $user->image,
                ],
                'likes' => $likes,
                'category' => [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                ],
                'views' => $post['views'],
                'created_at' =>  date('Y-m-d H:i' , strtotime($post['created_at'])),
                'updated_at' =>  date('Y-m-d H:i' , strtotime($post['updated_at'])),
            ];
        }

        $categoryData[] = [
            'id' => $category['id'],
            'name' => $category['name'],
            'created_at' =>  date('Y-m-d H:i' , strtotime($category['created_at'])),
            'sub_categories' => $subcatData,
            'posts' => $postsData
        ];

        return response()->json($categoryData);
    }
}
