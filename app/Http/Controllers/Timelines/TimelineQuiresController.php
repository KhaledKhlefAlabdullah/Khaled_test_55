<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timelines\TimelineQuiresRequest;
use App\Http\Resources\Timeline\TimelineQuireResource;
use App\Models\Timelines\TimelineQuire;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class TimelineQuiresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the timelines quires by auth id
        $data = TimelineQuire::where('stakeholder_id', auth()->user()->id)->paginate();

        return transformCollection($data, TimelineQuireResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TimelineQuiresRequest $request)
    {
        // validate the request
        $valid_data = $request->validated();

        // create the timeline quire
        $timeline_quire = TimelineQuire::create($valid_data);

        return new TimelineQuireResource($timeline_quire);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get timeline event by ID and check if existing
        try {
            $data = getAndCheckModelById(TimelineQuire::class, $id);

            return new TimelineQuireResource($data);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get timeline event by ID and check if existing
        try {
            $data = getAndCheckModelById(TimelineQuire::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // delete the timeline quire
        $data->delete();

        return response()->json(['message' => 'Timelines quire deleted successfully']);
    }
}
