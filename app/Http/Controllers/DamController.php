<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dam\StoreDamRequest;
use App\Http\Requests\Dam\UpdateDamRequest;
use App\Http\Resources\DamResource;
use App\Models\Dam;

class DamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all Dams
        $dams = Dam::paginate();

        // Return DamResource collection
        return ($dams->count() == 1)
            ? new DamResource($dams->first())
            : DamResource::collection($dams);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDamRequest $request)
    {
        // Validate the Dam
        $valid_data = $request->validated();

        // Create Dam
        $dam = Dam::create($valid_data);

        // Return DamResource
        return new DamResource($dam);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get Dam by ID
        $dam = Dam::find($id);

        // Check dam exists
        if (!$dam) {
            return response()->json(['message' => 'Dam not found'], 404);
        }

        return new DamResource($dam);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDamRequest $request, string $id)
    {
        // Get Dam by ID
        $dam = Dam::find($id);

        // Check dam exists
        if (!$dam) {
            return response()->json(['message' => 'Dam not found'], 404);
        }

        // Validate the Dam
        $valid_data = $request->validated();

        // Update Dam
        $dam->update($valid_data);

        // Return DamResource
        return new DamResource($dam);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get Dam by ID
        $dam = Dam::find($id);

        // Check dam exists
        if (!$dam) {
            return response()->json(['message' => 'Dam not found'], 404);
        }
        // Delete Dam
        $dam->delete();

        return response()->json(['message' => 'Dam deleted successfully'],);
    }
}
