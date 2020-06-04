<?php

namespace App\Http\Controllers\Api\V1\trash;

use App\Category;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\helper;

class CategoryController extends Controller
{
    // Super Admin Functions
    public function destory($id){
        $category = Category::withTrashed()->findOrFail($id);
        if ($category->trashed())
        {
            $category->forceDelete();
            $status = 1;
            $message="Category Deleted successfully";
            return jsonResponse($status, $message , $category);
        }
    }

    public function trashed()
    {
        $category = Category::onlyTrashed()->get() ;
        return response()->json($category) ;
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        if ($category->subfrom){
            $parent = Category::find($category->subfrom);
            if (!$parent){
                $status = 0;
                $message = 'parent category for this sub category not exist' ;
                return jsonResponse($status, $message , $replay );
            }
        }

        $category->restore();

        $status = 1;
        $message="Category Restored successfully";
        return jsonResponse($status, $message , $category);

    }
}
