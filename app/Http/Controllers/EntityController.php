<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntityRequest;
use App\Http\Resources\EntityResource;
use App\Models\Entity;
use App\Models\Stakeholder;
use Illuminate\Support\Facades\DB;
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
                ->join('entities','categories.id','=','entities.category_id')
                ->select('entities.id as id','entities.from as from','entities.to as to','entities.usage as usage')
                ->where(['entities.stakeholder_id'=>$stakeholder_id,'categories.name'=>'Route'])->get();

            return response()->json([
                'routes' => $routes,
                'message' => __('Successfully getting routes')
            ],200);

        }
        catch(\Exception $e){
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there error in server side try another time')
            ],500);
        }
    }
}
