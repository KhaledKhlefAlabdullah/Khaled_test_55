<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Spatie\FlareClient\Http\Exceptions\BadResponseCode;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all categories paginated
        $categories = Category::paginate();

        return $categories->count() == 1
            ? new CategoryResource($categories->first()) // return a single category
            : CategoryResource::collection($categories); // return a collection of categories
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // Validate the request data
        $valid_data = $request->validated();

        // Create the category
        $category = Category::create($valid_data);

        // Return the newly created category
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the specified category
        $category = Category::find($id);

        // Check if the category exists
        if (!$category) {
            return response()->json(['message' => 'Category ID not found'], 404);
        }

        // Return the specified category
        return new CategoryResource($category);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {

        // Get the category
        $category = Category::find($id);

        // Check if the category exists
        if (!$category) {
            return response()->json(['message' => 'Category ID not found'], 404);
        }

        try {
            // Validate the request
            $valid_data = $request->validated();

            // Update the category
            $category->update($valid_data);

            // Return the category
            return new CategoryResource($category);
        } catch (BadResponseCode $e) {
            // Return the error message if category id equals parent id
            return response()->json(['error' => $e->getMessage()], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the category
        $category = Category::find($id);

        // Check if the category exists
        if (!$category) {
            return response()->json(['message' => 'Category ID not found'], 404);
        }

        // Delete the category
        $category->delete();

        // Return message success
        return response()->json(['message' => 'Deleted successfully']);
    }
}
