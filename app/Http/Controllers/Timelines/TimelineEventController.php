<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timelines\TimelineEventRequest;
use App\Http\Resources\Timeline\TimelineEventResource;
use App\Models\Timelines\Timeline_event;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class TimelineEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Timeline_event::where('stakeholder_id', auth()->user()->id)
            ->where('is_active', true)
            ->get();


        return transformCollection($data, TimelineEventResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimelineEventRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the resource
        $data = Timeline_event::create($valid_data);

        return new TimelineEventResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get timeline event by ID and check if existing
        try {
            $data = getAndCheckModelById(Timeline_event::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return new TimelineEventResource($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TimelineEventRequest $request, string $id)
    {
        // Get timeline event by ID and check if existing
        try {
            $data = getAndCheckModelById(Timeline_event::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Validate the request
        $valid_data = $request->validated();

        // Update the resource
        $data->update($valid_data);

        return new TimelineEventResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get timeline event by ID and check if existing
        try {
            $data = getAndCheckModelById(Timeline_event::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the resource
        $data->delete();

        return response()->json(['message' => 'Timelines event deleted successfully']);
    }
}
