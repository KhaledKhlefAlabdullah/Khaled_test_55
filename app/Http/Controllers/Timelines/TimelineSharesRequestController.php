<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timelines\TimelineShareRequest;
use App\Http\Resources\Timeline\TimelineShareRequestResource;
use App\Models\Timelines\Timeline;
use App\Models\Timelines\TimelineSharesRequest;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIndustrialAreaID;
use function App\Helpers\stakeholder_id;
use function App\Helpers\transformCollection;

class TimelineSharesRequestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try {

            $share_requests = TimelineSharesRequest::select('timeline_id', 'sender.name', 'sender.avatar_URL as avatar_url')
                ->join('stakeholders', 'timeline_shares_requests.send_stakeholder_id', '=', 'stakeholders.id')
                ->leftJoin('user_profiles as sender', 'stakeholders.user_id', '=', 'sender.user_id')
                ->where('timeline_shares_requests.receive_stakeholder_id', stakeholder_id())
                ->get();

            return api_response(data: $share_requests, message: 'share-requests-getting-success');

        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'share-requests-getting-error', code: 500);
        }
    }

    /**
     * Get the companies in the same industrial area
     */
    public function get_companies_in_same_industrial_area()
    {
        try {

            $compaies = UserProfile::select('stakeholders.id as stakeholder_id', 'user_profiles.name', 'user_profiles.avatar_url')
                ->join('stakeholders', 'user_profiles.user_id', '=', 'stakeholders.user_id')
                ->where('industrial_area_id', getIndustrialAreaID())->get();

            return api_response(data: $compaies, message: 'compaies-getting-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'compaies-getting-error', code: 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimelineShareRequest $request)
    {
        try {

            // Validate the request
            $valid_data = $request->validated();

            // Get the receiver id
            $receiver_id = $request->input('receive_stakeholder_id');

            // Get the timeline id
            $timeline_id = Timeline::where('stakeholder_id', $receiver_id)->first()->id;

            // Create the timeline share request
            TimelineSharesRequest::create([
                'timeline_id' => $timeline_id,
                'send_stakeholder_id' => stakeholder_id(),
                'receive_stakeholder_id' => $receiver_id,
                'send_date' => now(),
                'end_date' => now()->addDays(10)
            ]);

            return api_response(message: 'share-request-sending-success');
        } catch (Exception $e) {

            return api_response(errors: [$e->getMessage()], message: 'share-request-sending-error', code: 500);
        }
    }


    /**
     * Accept Or Reject Share Request
     */
    public function accept_reject(TimelineShareRequest $request, string $share_request_id)
    {
        try{

            $share_request = getAndCheckModelById(TimelineSharesRequest::class, $share_request_id);

            $share_request->update([
                'status' => $request->input('status')
            ]);

            return api_response(message:'share-request-accept-reject-success');
        }
        catch(Exception $e){

            return api_response(errors:[$e->getMessage()],message:'share-request-accept-reject-error',code:500);
        }
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
