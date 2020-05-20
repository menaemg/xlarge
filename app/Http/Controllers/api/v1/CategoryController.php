<?php

namespace App\Http\Controllers\Api\V1;

use App\Category;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\helper;

class CategoryController extends Controller
{

    // Get /categories
    // show all categories data
    public function index()
    {
        return response()->json(Category::all());
    }

    // Post /categories/create
    // create new category
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
            'subfrom' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        if ($request->subfrom){
            // check if parent is sub from
            $parentCategory = Category::find($request->subfrom);
            if (!$parentCategory->subfrom == null){
                return jsonResponse(0, ['subfrom' => "The selected subfrom is invalid."] , $request->all() );
            }
        }

        $category = Category::create( $request->all());


        // if category created successfully
        $status = 1;
        $message = 'category created successfully';

        return jsonResponse($status, $message , $category );
    }


    // Get /categories/show/{categories}
    // show category data
    public function show(Category $category)
    {
        return response()->json($category);
    }


    // Post /categories/update/{categories}
    // update onr category
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string' , 'max:255', \Illuminate\Validation\Rule::unique('categories')->ignore($category) ],
            'description' => 'nullable|string|max:1000',
            'subfrom' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        if ($request->subfrom){
            // check if parent is sub from another category
            $parentCategory = Category::find($request->subfrom);
            if (!$parentCategory->subfrom == null){
                return jsonResponse(0, ['subfrom' => "The selected parent is invalid."] , $request->all() );
            }
            // check if subform is the parent
            if ($request->subfrom == $category->id ){
                return jsonResponse(0, ['subfrom' => "parent can't be sub category in same time."] , $request->all() );
            }
            // check if this category has sub categories
            $subCategories = Category::where('subfrom' , $category->id)->count();
            if ($subCategories){
                return jsonResponse(0, ['subfrom' => "Delete or remove sub categories first."] , $request->all() );
            }
        }

        $category->update($request->all());


        // if category updated successfully
        $status = 1;
        $message = 'category updated successfully';

        return jsonResponse($status, $message , $category );
    }


    // Added Soft Delete To destroy function
    public function destroy($id)
    {
        $category =Category::withTrashed()->findOrFail($id);
        if ($category->trashed())
        {
            $category->forceDelete();
            $status = 1;
            $message="Category Deleted successfully";
            return jsonResponse($status, $message , $category);
        }
        else
        {
            // check if this category has sub categories
            $subCategories = Category::where('subfrom' , $category->id)->count();
            if ($subCategories){
                return jsonResponse(0, ['subfrom' => "Delete or remove sub categories first."] , $category );
            }

            $category->delete();
            $status = 1;
            $message="Category Trashed successfully";
            return jsonResponse($status, $message , $category);
        }
    }

    // Super Admin Functions
    public function trashed()
    {
        $category = Category::onlyTrashed()->get() ;
        return response()->json($category) ;
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id)->restore() ;
        $status = 1;
        $message="Category Restored successfully";
        return jsonResponse($status, $message , $category);
    }
}
