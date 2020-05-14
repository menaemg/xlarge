<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Comment::all());
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
            'content' => ['required','max:1000' , 'min:1'],
            'post_id' => 'exists:posts,id',
            'user_id' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        Comment::create( $request->all());
        $ms = 'success';
        return response()->json($ms);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required','max:255' , 'min:1'],
            'post_id' => 'exists:posts,id',
            'user_id' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $comment->update( $request->all());
        $ms = 'success';
        return response()->json($ms);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {

        $comment->delete();
        $msg="Comment deleted";
        return response()->json($msg);
    }
}
