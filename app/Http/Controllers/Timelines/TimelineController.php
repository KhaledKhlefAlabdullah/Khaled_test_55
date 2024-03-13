<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Requests\Timelines\TimelineRequest;
use App\Http\Resources\Timeline\TimelineResource;
use App\Models\Timelines\Timeline;
use App\Models\Timelines\TimelineEvent;
use App\Models\Timelines\TimelineSharesRequest;
use App\Models\UserProfile;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIndustrialAreaID;
use function App\Helpers\stakeholder_id;
use function App\Helpers\transformCollection;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // View shared Timeline table that includes :Date (horizontal axis) - Current day - Company Name (Vertical axis) - Company status-  Event(Title - Available Resources (Resource Name - Quantity) - Start Date - End Date - Last Update -  Inquiries)		
    /*
    timeline event attributes
        'timeline_id',
        'stakeholder_id',
        'category_id',
        'title',
        'start_date',
        'end_date',
        'description',
        'production_percentage',
        'is_active'
    */
    public function index()
    {
        try {

            $industrial_area_id = getIndustrialAreaID();

            // Retrieve the IDs of accepted timelines shared with you
            $accepted_timelines = TimelineSharesRequest::where([
                'send_stakeholder_id' => stakeholder_id(),
                'status' => 'accept'
            ])->pluck('timeline_id');
            // Retrieve your own timeline ID
            $my_timeline_id = Timeline::where('stakeholder_id', stakeholder_id())->value('id');

            // Combine your own timeline ID with the accepted timelines
            $timeline_ids = $accepted_timelines->push($my_timeline_id)->toArray();

            $timelines = TimelineEvent::select('up.name as company_name', 'sk.tenant_company_state as company_state', 'tls.id as timeline_id')
                ->selectRaw('GROUP_CONCAT(timeline_events.id) as events_ids')
                ->selectRaw('GROUP_CONCAT(timeline_events.title) as events_titles')
                ->selectRaw('GROUP_CONCAT(c.name) as events_categories')
                ->selectRaw('GROUP_CONCAT(c.color) as events_colors')
                ->selectRaw('GROUP_CONCAT(timeline_events.description) as events_descriptions')
                ->selectRaw('GROUP_CONCAT(timeline_events.start_date) as events_start_dates')
                ->selectRaw('GROUP_CONCAT(timeline_events.end_date) as events_end_dates')
                ->selectRaw('GROUP_CONCAT(timeline_events.production_percentage) as events_production_percentages')
                ->selectRaw('GROUP_CONCAT(timeline_events.is_active) as events_is_active')
                ->selectRaw('GROUP_CONCAT(timeline_events.updated_at) as events_updated_at')
                ->leftJoin('timelines as tls', 'timeline_events.timeline_id', '=', 'tls.id')
                ->leftJoin('stakeholders as sk', 'tls.stakeholder_id', '=', 'sk.id')
                ->leftJoin('categories as c', 'timeline_events.category_id', '=', 'c.id')
                ->leftJoin('user_profiles as up', 'sk.user_id', '=', 'up.user_id')
                ->whereIn('tls.id', $timeline_ids)
                ->where('sk.industrial_area_id', $industrial_area_id)
                ->groupBy('up.name', 'sk.tenant_company_state', 'tls.id')
                ->get();

            $data = $timelines->map(function ($items) {
                return [
                    'company_name' => $items->timeline_id == Auth::user()->stakeholder->timelines->id ? 'My company' : $items->company_name,
                    'company_state' => $items->company_state,
                    'timeline_id' => $items->timeline_id,
                    'events' => collect(explode(',', $items->events_ids))->map(function ($id, $index) use ($items) {
                        return [
                            'event_id' => $id,
                            'event_title' => explode(',', $items->events_titles)[$index],
                            'event_category' => explode(',', $items->events_categories)[$index],
                            'event_color' => explode(',', $items->events_colors)[$index],
                            'event_description' => explode(',', $items->events_descriptions)[$index],
                            'event_start_date' => explode(',', $items->events_start_dates)[$index],
                            'event_end_date' => explode(',', $items->events_end_dates)[$index],
                            'event_production_percentage' => explode(',', $items->events_production_percentages)[$index],
                            'event_is_active' => explode(',', $items->events_is_active)[$index],
                            'event_updated_at' => explode(',', $items->events_updated_at)[$index]
                        ];
                    })
                ];
            });

            return api_response(data: $data, message: 'Timelines-grtting-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'Timelines-grtting-error', code: 500);
        }
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
