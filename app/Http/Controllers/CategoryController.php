<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Validator;
use App\Helpers\helper;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Category::all());
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
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $category = Category::create( $request->all());

        $status = 1;
        $message = 'category created successful';

        return jsonResponse($status, $message , $category );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string' , 'max:255', \Illuminate\Validation\Rule::unique('categories')->ignore($category) ],
            'description' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            $status = 0;
            return jsonResponse($status, $validator->messages() , $request->all());
        }

        $category->update( $request->all());

        $status = 1;
        $message = 'category updated successful';

        return jsonResponse($status, $message , $category );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

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
