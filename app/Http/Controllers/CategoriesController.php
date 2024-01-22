<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return CategoryResource::collection(Category::paginate());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $valid_data = $request->validated();
            $category = Category::create($valid_data);

            return new CategoryResource($category);


    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
            return new CategoryResource($category);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
            $valid_data = $request->validated();
            $category->update($valid_data);

            return new CategoryResource($category);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        $category->delete();

            return response()->json(null, 204);

    }
}
