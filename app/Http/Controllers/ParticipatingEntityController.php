<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipatingEntityRequest;
use App\Http\Resources\ParticipatingEntityResource;
use App\Models\ParticipatingEntity;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;

class ParticipatingEntityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ParticipatingEntity::paginate();

        return ($data->count() == 1)
            ? new ParticipatingEntityResource($data->first())
            : ParticipatingEntityResource::collection($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * Rule for [portal manager]
     */
    public function store(ParticipatingEntityRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the entity
        $entity = ParticipatingEntity::create($valid_data);

        return new ParticipatingEntityResource($entity);
    }

    /**
     * Display the specified resource.
     *
     * Rule for [portal manager]
     */
    public function show(string $id)
    {
        // Get the data by id and check if it exists
        try {
            $data = getAndCheckModelById(ParticipatingEntity::class, $id);

            return new ParticipatingEntityResource($data);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * Rule for [portal manager]
     */
    public function update(ParticipatingEntityRequest $request, string $id)
    {
        // Get the data by id and check if it exists
        try {
            $data = getAndCheckModelById(ParticipatingEntity::class, $id);

            // Validate the request
            $valid_data = $request->validated();

            // Update the entity
            $data->update($valid_data);

            return new ParticipatingEntityResource($data);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * Rule for [portal manager]
     */
    public function destroy(string $id)
    {
        // Get the data by id and check if it exists
        try {
            $data = getAndCheckModelById(ParticipatingEntity::class, $id);

            // Delete the entity
            $data->delete();

            return new ParticipatingEntityResource($data);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
