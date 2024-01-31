<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timelines\TimelineShareRequest;
use App\Http\Resources\Timeline\TimelineShareRequestResource;
use App\Models\Timelines\TimelineSharesRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class TimelineSharesRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|JsonResource|TimelineShareRequestResource
     */
    public function index()
    {
        // Get the ID of the currently authenticated user
        $currentUserId = Auth::id();

        // Retrieve timeline share requests for the authenticated user
        $timelineShareRequests = TimelineSharesRequest::
        where(function ($query) use ($currentUserId) {
            // Filter requests based on sender or receiver stakeholder ID matching the user's ID
            $query->where('send_stakeholder_id', $currentUserId)
                ->orWhere('receive_stakeholder_id', $currentUserId);
        })
            // Only consider accepted requests with a valid end date
            ->where('status', 'accept')
            ->whereDate('end_date', '>=', now())
            ->get();

        // Transform the results using the specified resource class
        return transformCollection($timelineShareRequests, TimelineShareRequestResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimelineShareRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the timeline share request
        $timelineShare = TimelineSharesRequest::create($valid_data);

        return new TimelineShareRequestResource($timelineShare);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get timeline share by ID and check if existing
        try {
            $data = getAndCheckModelById(TimelineSharesRequest::class, $id);

            return new TimelineShareRequestResource($data);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TimelineShareRequest $request, string $id)
    {
        // Get timeline share by ID and check if existing
        try {
            $data = getAndCheckModelById(TimelineSharesRequest::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Validate the request
        $valid_data = $request->validated();

        // Update the timeline share
        $data->update($valid_data);

        return new TimelineShareRequestResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get timeline share by ID and check if existing
        try {
            $data = getAndCheckModelById(TimelineSharesRequest::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the timeline share
        $data->delete();

        return response()->json(['message' => 'Timelines share request deleted successfully']);
    }
}
