<?php

namespace App\Http\Controllers;

use App\Http\Requests\NaturalDisasterRequest;
use App\Http\Resources\NaturalDisasterResource;
use App\Models\NaturalDisaster;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;

class NaturalDisasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all Natural Disasters
        $data = NaturalDisaster::paginate();

        return ($data->count() == 1)
            ? new NaturalDisasterResource($data->first())
            : NaturalDisasterResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NaturalDisasterRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the Natural Disaster
        $natural_disaster = NaturalDisaster::create($valid_data);

        return new NaturalDisasterResource($natural_disaster);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Get the Natural Disaster by ID and check if the Natural Disaster exists
            $natural_disaster = getAndCheckModelById(NaturalDisaster::class, $id);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return new NaturalDisasterResource($natural_disaster);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NaturalDisasterRequest $request, string $id)
    {
        try {
            // Get the Natural Disaster by ID and check if the Natural Disaster exists
            $natural_disaster = getAndCheckModelById(NaturalDisaster::class, $id);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }


        // Validate the request
        $valid_data = $request->validated();

        // Update the Natural Disaster
        $natural_disaster->update($valid_data);

        return new NaturalDisasterResource($natural_disaster);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Get the Natural Disaster by ID and check if the Natural Disaster exists
            $natural_disaster = getAndCheckModelById(NaturalDisaster::class, $id);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the Natural Disaster
        $natural_disaster->delete();

        return response()->json(['message' => 'Natural Disaster deleted successfully']);
    }

}
