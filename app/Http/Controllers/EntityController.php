<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntityRequest;
use App\Http\Resources\EntityResource;
use App\Models\Entity;
use App\Models\Stakeholder;


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
}
