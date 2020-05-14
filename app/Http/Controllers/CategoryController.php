<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Validator;

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
            'name' => ['required','max:255' , 'min:3', 'unique:categories'],
            'description' => 'required|min:3|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        Category::create( $request->all());
        $ms = 'success';
        return response()->json($ms);
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
            'name' => ['required','max:255' , 'min:3', \Illuminate\Validation\Rule::unique('categories')->ignore($category) ],
            'description' => 'min:3',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $category->update( $request->all());
        $ms = 'success';
        return response()->json($ms);
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
            $message = 'Category Deleted Successfully' ; 
            return response()->json($message); 
        } 
        else
        {
            $category->delete();
            $msg="Category Trashed Successfully";
            return response()->json($msg);
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
        Category::onlyTrashed()->findOrFail($id)->restore() ; 
        $message = 'Category Restored Successfully' ; 
        return response()->json($message) ; 
    }
}
