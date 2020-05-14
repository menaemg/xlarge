<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|min:3|max:255',
            'content' => 'string|required|min:3|max:10000',
            'status' => 'boolean',
            'image' => 'required|image',
            'user_id' => 'exists:users,id',
            'category_id' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'image' => $request->image->store('images', 'public'),
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
        ]);
        $ms = 'success';
        return response()->json($ms);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:255|min:3',
            'content' => 'string|required|min:3|max:10000',
            'status' => 'boolean',
            'image' => 'required|image',
            'user_id' => 'exists:users,id',
            'category_id' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $post->update([ $request->all()
            // 'title' => $request->title,
            // 'content' => $request->content,
            // 'status' => $request->status,
            // 'image' => $request->image->store('images', 'public'),
            // 'user_id' => $request->user_id,
            // 'category_id' => $request->category_id,
        ]);
        $ms = 'success';
        return response()->json($ms);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->findOrFail($id) ; 
        if ($post->trashed())
        {
            $post->forceDelete(); 
            $message = 'Post Deleted Successfully'; 
            return response()->json($message); 
        }
        else
        {
            $post->delete();
            $msg="Post Trashed Successfully";
            return response()->json($msg);
        }
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->get(); 
        return response()->json($posts);
    }

    public function restore($id)
    {
        Post::onlyTrashed()->findOrFail($id)->restore();
        $msg="Post Restored Successfully";
        return response()->json($msg);
    }
}
