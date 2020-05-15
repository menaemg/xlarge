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
            'content' => 'required|max:1000|min:1',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $comment = Comment::create( $request->all());

        $status = 1;
        $message = 'comments created successfully';

        return jsonResponse($status, $message , $comment );
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
            'content' => 'required|max:255|min:1',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $comment->update( $request->all());

        $status = 1;
        $message = 'comments update successfully';

        return jsonResponse($status, $message , $comment );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        if($comment->trashed())
        {
            $comment->forceDelete();
            $status = 1;
            $message = 'Comment Deleted Successfully' ;
            return jsonResponse($status, $message , $comment );
        }
        else
        {
            $comment->delete();
            $status = 1;
            $message = 'Comment Trashed Successfully' ;
            return jsonResponse($status, $message , $comment );
        }
    }

    public function trashed()
    {
        $trashed = Comment::onlyTrashed()->get();
        return response()->json($trashed);
    }

    public function restore($id)
    {
        $comment = Comment::onlyTrashed()->findOrFail($id)->restore();
        $status = 1;
        $message = 'Comment Restored Successfully' ;
        return jsonResponse($status, $message , $comment );
    }
}
