<?php

namespace App\Http\Controllers\Api\V1\trash;

use App\Post;
use App\User;
use App\Category;
use Storage;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    // Super Admin Functions
    public function destory($id){
        $post = Post::withTrashed()->findOrFail($id);
        if ($post->trashed())
        {
            $saved = [
                'avatar.png' ,
                'xlarge.png'
            ];
            $image = $post->image;
            $imageName = basename($image);
            if (!in_array($imageName , $saved)) {
                Storage::disk('public')->delete('images/' . $imageName);
            }
            $post->forceDelete();
            $status = 1;
            $message="Post Deleted successfully";
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
        $post = Post::onlyTrashed()->findOrFail($id);

        $user = User::find($post->user_id);

        if ($post->category_id != null){
            $category = Category::find($post->category_id);

            if (!$category) {
                $status = 0;
                $message = 'category for this post not exist' ;
                return jsonResponse($status, $message , $replay );
            }
        }

        if (!$user){
            $status = 0;
            $message = 'user for this post not exist' ;
            return jsonResponse($status, $message , $replay );
        }

        $post->restore();
        $status = 1;
        $message="Post Restored successfully";
        return jsonResponse($status, $message , $post);
    }
}
