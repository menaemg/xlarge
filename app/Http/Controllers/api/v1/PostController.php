<?php

namespace App\Http\Controllers\Api\V1;

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
            'user_id' => 'exists:users,id',
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

        // set post status to public
        if ($request->status == null){
            $status = 1;
        } else {
            $status = $request->status;
        };

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'image' =>  $imageName,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);


        // if post created successfully
        $status = 1;
        $message = 'post created successfully';

        return jsonResponse($status, $message , $post );
    }


    // Get /posts/show/{post}
    // show post info
    public function show(Post $post)
    {
        // add 1 to post views counter
        $views = $post->views + 1;

        // update post views
        $post->update([
            'views' => $views
        ]);

        return response()->json($post);
    }


    // Post /posts/edit/{post}
    // edit the post
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:255',
            'content' => 'string|required|max:10000',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image',
            'user_id' => 'required|exists:users,id',
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

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
            'image' => $imageName,
            'user_id' => $request->user_id,
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
        if ($post->trashed())
        {
            $post->forceDelete();
            $status = 1;
            $message="Post Deleted successfully";
            return jsonResponse($status, $message , $post);
        }
        else
        {
            $post->delete();
            $status = 1;
            $message="Post Trashed successfully";
            return jsonResponse($status, $message , $post);
        }
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->get();
        return response()->json($posts);
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id)->restore();
        $status = 1;
        $message="Post Restored successfully";
        return jsonResponse($status, $message , $post);
    }
}
