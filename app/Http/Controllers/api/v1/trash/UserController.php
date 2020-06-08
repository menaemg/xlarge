<?php

namespace App\Http\Controllers\Api\V1\trash;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Hash;
use Storage;


class UserController extends Controller
{
    // Super Admin Functions
    public function destory($id){
        $user = User::withTrashed()->findOrFail($id);
        if ($user->trashed())
        {
            $saved = [
                'avatar.png',
                'xlarge.png'
        ];
            $image = $user->image;
            $imageName = basename($image);
            if (!in_array($imageName , $saved)) {
                Storage::disk('public')->delete('images/' . $imageName);
            }
            $user->forceDelete();
            $status = 1;
            $message="User Deleted successfully";
            return jsonResponse($status, $message , $user);
        }
    }
    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return response()->json($users);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id)->restore();
        $user = User::find($id);
        $status = 1;
        $message="User Restored successfully";
        return jsonResponse($status, $message , $user);
    }
}
