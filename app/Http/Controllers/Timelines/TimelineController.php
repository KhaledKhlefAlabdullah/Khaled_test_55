<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timelines\TimelineRequest;
use App\Http\Resources\Timeline\TimelineResource;
use App\Models\Timelines\Timeline;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get timeline by auth user
        $timeline = Timeline::whereStakeholderId(auth()->user()->id)->get();

        return transformCollection($timeline, TimelineResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TimelineRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the timeline
        $timeline = Timeline::create($valid_data);

        return new TimelineResource($timeline);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the timeline by ID and check if existing
        try {
            $data = getAndCheckModelById(Timeline::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the timeline
        $data->delete();

        return response()->json(['message' => 'Timelines deleted successfully']);
    }
}
