<?php

namespace App\Http\Controllers\Api\V1\editor;

use App\Post;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{

    // Get /users
    // show all user data
    public function index()
    {
        return response()->json(Post::all());
    }

    // Post /users/create
    // Create new user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:255',
            'content' => 'string|required|max:10000',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image',
            'user_id' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }


        // store post image in storage/images
        if ($request->image){
            $imageName = 'http://127.0.0.1:8000///storage/' . $request->image->store('images', 'public');

        // set default image for post
        } else {
            $imageName = 'http://127.0.0.1:8000///storage/images/xlarge.png';
        };

        // set default post status to public
        if ($request->status == null){
            $status = 1;
        } else {
            $status = $request->status;
        };

        // set default user id to auth user
        if ($request->user_id == null){
            $user_id = Auth('api')->user()->id;
        } else {
            $user_id = $request->user_id;
        };

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'image' =>  $imageName,
            'user_id' => $user_id,
            'category_id' => $request->category_id,
        ]);


        // if post created successfully
        $status = 1;
        $message = 'post created successfully';

        return jsonResponse($status, $message , $post );
    }


    // Get /posts/show/{post}
    // show post info
    public function show($post)
    {
        $post = Post::findOrFail($post);
        return response()->json($post);
    }


    // Post /posts/edit/{post}
    // edit the post
    public function update(Request $request, $post)
    {
        $post = Post::findOrFail($post);

        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:255',
            'content' => 'string|required|max:10000',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image',
            'user_id' => 'nullable|exists:users,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        // update post image
        if ($request->image){
            $imageName = 'http://127.0.0.1:8000///storage/' . $request->image->store('images', 'public');

        // set old image if request image is null
        } else {
            $imageName = $post->image;
        };

        // set default status for post to public
        if ($request->status == null){
            $status = 1;
        } else {
            $status = $request->status;
        };

        // set default user id to auth user
        if ($request->user_id == null){
            $user_id = Auth('api')->user()->id;
        } else {
            $user_id = $request->user_id;
        };

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'image' => $imageName,
            'user_id' => $user_id,
            'category_id' => $request->category_id,
        ]);


        // if post updated successfull
        $status = 1;
        $message = 'post updated successfully';

        return jsonResponse($status, $message , $post );
    }

    // post /posts/delete/{post}
    // trashed one post
    public function destroy($id)
    {
        $post = Post::withTrashed()->findOrFail($id) ;
        if (!$post->trashed())
        {
            $post->delete();
            $status = 1;
            $message="post Trashed successfully";
            return jsonResponse($status, $message , $post);
        } else {
            $status = 0;
            $message="you can't delete this post";
            return jsonResponse($status, $message , $post);
        }
    }

}
