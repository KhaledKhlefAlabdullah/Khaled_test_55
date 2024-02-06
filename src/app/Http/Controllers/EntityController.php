<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntityRequest;
use App\Http\Resources\EntityResource;
use App\Models\Category;
use App\Models\Entity;
use App\Models\Stakeholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIdByName;
use function App\Helpers\stakeholder_id;


class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get Entity using relationship
        $entities = Stakeholder::with('entities')->get();

        return ($entities->count() == 1)
            ? new EntityResource($entities->first())
            : EntityResource::collection($entities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EntityRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the Entity
        $entity = Entity::create($valid_data);

        return new EntityResource($entity);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the entity
        $entity = Entity::find($id);

        if (!$entity) {
            return response()->json(['message' => 'Entity not found'], 404);
        }

        // Return the entity
        return new EntityResource($entity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EntityRequest $request, string $id)
    {
        // Get the entity
        $entity = Entity::fined($id);

        if (!$entity) {
            return response()->json(['message' => 'Entity not found'], 404);
        }

        // Validate the request
        $valid_data = $request->validated();

        // Update the entity
        $entity->update($valid_data);

        return new EntityResource($entity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the entity by ID
        $entity = Entity::fined($id);

        if (!$entity) {
            return response()->json(['message' => 'Entity not found'], 404);
        }

        // Delete the entity
        $entity->delete();

        return response()->json(['message' => 'Entity deleted successfully']);
    }

    /**
     * Get all routes in database with route usage
     */
    public function get_routes()
    {
        try {

            $stakeholder_id = stakeholder_id();

            $routes = DB::table('categories')
                ->join('entities', 'categories.id', '=', 'entities.category_id')
                ->select('entities.public_id as id', 'entities.from as from', 'entities.to as to', 'entities.usage as usage')
                ->where(['entities.stakeholder_id' => $stakeholder_id, 'categories.name' => 'Route'])->get();

            return response()->json([
                'routes' => $routes,
                'message' => __('Successfully getting routes')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there error in server side try another time')
            ], 500);
        }
    }

    /**
     * Add new route details
     */
    public function add_new_route(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|string|unique:entities,public_id',
                'from' => 'required|string',
                'to' => 'required|string',
                'usage' => 'required|string|in:Employees transportation,Shipping,Supplies,waste'
            ]);

            $entity = Entity::create([
                'stakeholder_id' => stakeholder_id(),
                'category_id' => getIdByName(Category::class, 'Route'),
                'public_id' => $request->input('id'),
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'usage' => $request->input('usage'),
                'is_available' => true
            ]);

            return response()->json([
                'data' => $entity,
                'message' => __('Successfully adding new route')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in adding rout try again')
            ], 500);
        }
    }

    /**
     * Edite route details
     */
    public function edite_route_details(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|string|exists:entities,id',
                'from' => 'required|string',
                'to' => 'required|string',
                'usage' => 'required|string|in:Employees transportation,Shipping,Supplies,waste'
            ]);

            $id = $request->input('id');

            $entity = getAndCheckModelById(Entity::class, $id);

            $entity->update([
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'usage' => $request->input('usage')
            ]);

            return response()->json([
                'data' => $entity,
                'message' => __('Successfully adding new route')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in editing rout details try again')
            ], 500);
        }
    }

    /**
     * Delete Route
     */
    public function delete_route(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|string|exists:entities,id'
            ]);

            $id = $request->input('id');

            $entity = getAndCheckModelById(Entity::class, $id);

            $entity->delete();

            return response()->json([
                'message' => __('The route deleted successfully')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in deleting rout details try again')
            ], 500);
        }
    }

    /**
     * View production sites list
     */
    public function production_sites()
    {
        try {

            $category_id = getIdByName(Category::class, 'Production Site');

            $production_sites = Entity::where(['category_id' => $category_id, 'stakeholder_id' => stakeholder_id()])
                ->select('entities.id', 'entities.name as production site name', 'entities.location')->get();

            return response()->json([
                'data' => $production_sites,
                'message' => __('Successfully getting the production sites')
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in getting the production sites try again')
            ], 500);
        }
    }
}
