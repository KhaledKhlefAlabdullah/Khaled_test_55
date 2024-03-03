<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Spatie\FlareClient\Http\Exceptions\BadResponseCode;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIdByName;

class CategoriesController extends Controller
{

      /**
     * Get the categories for the manuals and plans
     */
    public function get_manula_and_plans_categories()
    {
        return $this->categories_by_paarent_id(getIdByName(Category::class,'Manuals And Plans')); 
    }

    /**
     * Get the categories by parent id
     */
    public function categories_by_paarent_id(string $parent_id){
        try{

            $categories = Category::where('parent_id',$parent_id)->select('id','name')->get();

            return api_response(data:$categories,message:'categories-getting-error');
        }
        catch(Exception $e){
            return api_response(errors:[$e->getMessage()],message:'categories-getting-error',code:500);
        }
    }

    /**
     * Display a listing of the categories.
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
        // Get the category by ID and check if it exists
        try {
            $category = getAndCheckModelById(Category::class, $id);
            // Return the specified category
            return new CategoryResource($category);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {

        // Get the category by ID and check if it exists
        try {
            $category = getAndCheckModelById(Category::class, $id);

            $valid_data = $request->validated();

            // Update the category
            $category->update($valid_data);

            // Return the category
            return new CategoryResource($category);
        } catch (BadResponseCode $e) {
            // Return the error message if category id equals parent id
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the category by ID and check if it exists
        try {
            $category = getAndCheckModelById(Category::class, $id);
            // Delete the category
            $category->delete();

            // Return message success
            return response()->json(['message' => 'Deleted successfully']);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }


    }
}
