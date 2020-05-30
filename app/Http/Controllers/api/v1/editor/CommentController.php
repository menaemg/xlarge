<?php

namespace App\Http\Controllers\Api\V1\editor;

use App\Comment;
use App\Replay;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    // Get /comments
    // show all comments data
    public function index()
    {

        $comments = Comment::all();
        $comments = $comments->toArray();
        $commentsData = [];
        foreach ($comments as $comment){

            $replies = Replay::where('comment_id' , $comment['id'])->get();
            $commentsData[] = [
                'id' => $comment['id'],
                'content' => $comment['content'],
                'user_id' => $comment['user_id'],
                'post_id' => $comment['post_id'],
                'created_at' => date('Y-m-d H:i' , strtotime($comment['created_at'])),
                'updated_at' => date('Y-m-d H:i' , strtotime($comment['updated_at'])),
                'replaies' => $replies
            ];
        }

        return response()->json($commentsData);
    }

    // Post /comments/create
    // Create new comments
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|max:1000',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        // set default value to Auth usr
        if ($request->user_id == null){
            $user_id = Auth('api')->user()->id;
        } else {
            $user_id = $request->user_id;
        }
        $comment = Comment::create( [
            'content' =>$request->content,
            'post_id' =>$request->post_id,
            'user_id' =>$user_id,
        ]);

        // if commnet creat successfully
        $status = 1;
        $message = 'comments created successfully';

        return jsonResponse($status, $message , $comment );
    }

    // Git  /comments/show/{comment}
    // show one comment
    public function show($comment)
    {
        $comment = Comment::findOrFail($comment);

        $replies = Replay::where('comment_id' , $comment->id)->get();

        $commentData = [];

        $commentData[] = [
            'id' => $comment['id'],
            'content' => $comment['content'],
            'user_id' => $comment['user_id'],
            'post_id' => $comment['post_id'],
            'created_at' => date('Y-m-d H:i' , strtotime($comment['created_at'])),
            'updated_at' => date('Y-m-d H:i' , strtotime($comment['updated_at'])),
            'replaies' => $replies
        ];

        return response()->json($commentData);
    }

    // Get /comment/edite/{commnet}
    // show all comment data
    public function update(Request $request, $comment)
    {
        $comment = Comment::findOrFail($comment);

        $validator = Validator::make($request->all(), [
            'content' => 'required|max:255',
            'post_id' => 'required|exists:posts,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        // set default value to Auth usr
        if ($request->user_id == null){
            $user_id = Auth('api')->user()->id;
        } else {
            $user_id = $request->user_id;
        }
        $comment->update( [
            'content' =>$request->content,
            'post_id' =>$request->post_id,
            'user_id' =>$user_id,
        ]);

        // if comment update successfully
        $status = 1;
        $message = 'Comment update successfully';

        return jsonResponse($status, $message , $comment );
    }


    public function destroy($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        if(!$comment->trashed())
        {
            $comment->delete();
            $status = 1;

            $replies = Replay::where('comment_id' , $comment->id)->delete();

            $message="Commnet Trashed successfully";
            return jsonResponse($status, $message , $comment);
        } else {
            $status = 0;
            $message="you can't delete this comment";
            return jsonResponse($status, $message , $comment);
        }
    }
}
