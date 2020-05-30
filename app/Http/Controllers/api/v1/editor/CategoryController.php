<?php

namespace App\Http\Controllers\Api\V1\editor;

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
        $categories = Category::where('subfrom' , null)->get();
        $categories = $categories->toArray();

        $categoriesData = [];

        foreach ($categories as $category){

            $subcats = Category::where('subfrom' , $category['id'])->get();
            $subcats = $subcats->toArray();
            $subcatData = [];

            foreach ($subcats as $subcat){
                $subcatData[] = [
                    'id' => $subcat['id'],
                    'name' => $subcat['name'],
                    'created_at' =>  date('Y-m-d H:i' , strtotime($subcat['created_at'])),
                ];
            }
            if ($subcatData == []){
                $subcatData = null;
            }
            $categoriesData[] = [
                'id' => $category['id'],
                'name' => $category['name'],
                'created_at' =>  date('Y-m-d H:i' , strtotime($category['created_at'])),
                'sub_categories' => $subcatData,

            ];
        }
        return response()->json($categoriesData);
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
                $status = 0;
                return jsonResponse($status , ['subfrom' => "The selected subfrom is invalid."] , $request->all() );
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
    public function show($category)
    {
        $category = Category::findOrFail($category);

        $subCategories = Category::where('subfrom' , $category->id)->get();

        $category->sub_categories = $subCategories;
        return response()->json($category);
    }


    // Post /categories/update/{categories}
    // update onr category
    public function update(Request $request,$category)
    {
        $category = Category::findOrFail($category);

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
                $status = 0;
                return jsonResponse($status, ['subfrom' => "The selected parent is invalid."] , $request->all() );
            }
            // check if subform is the parent
            if ($request->subfrom == $category->id ){
                $status = 0;
                return jsonResponse($status, ['subfrom' => "parent can't be sub category in same time."] , $request->all() );
            }
            // check if this category has sub categories
            $subCategories = Category::where('subfrom' , $category->id)->count();
            if ($subCategories){
                $status = 0;
                return jsonResponse($status , ['subfrom' => "Delete or remove sub categories first."] , $request->all() );
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
        if (!$category->trashed())
        {
            // check if this category has sub categories
            $subCategories = Category::where('subfrom' , $category->id)->count();
            if ($subCategories){
                $status = 0;
                return jsonResponse($status, ['subfrom' => "Delete or remove sub categories first."] , $category );
            }

            $category->delete();
            $status = 1;
            $message="category Trashed successfully";
            return jsonResponse($status, $message , $category);
        }
        else
        {
            $status = 0;
            $message="you can't delete this category";
            return jsonResponse($status, $message , $category);
        }
    }
}
