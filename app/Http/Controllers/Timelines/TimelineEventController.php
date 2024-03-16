<?php

namespace App\Http\Controllers\Timelines;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResourceController;
use App\Http\Requests\Timelines\TimelineEventRequest;
use App\Http\Resources\Timeline\TimelineEventResource;
use App\Models\EventResources;
use App\Models\Resource;
use App\Models\Timelines\Timeline;
use App\Models\Timelines\TimelineEvent;
use Exception;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function App\Helpers\api_response;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\stakeholder_id;
use function App\Helpers\transformCollection;

class TimelineEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = TimelineEvent::where('timeline_id',)
            ->where('is_active', true)
            ->get();


        return transformCollection($data, TimelineEventResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimelineEventRequest $request)
    {
        try {
            //Add an Event in the Timeline ( Title - Start Date - End Date - Description - Categories (Normal Production Rate - Extra Production rate - Low Production rate- Halted production- Evacuating- Maintenance- Relocation) - Available Resources (Resource - Quantity) ) 					
            $request->validated();

            $timeline_id = Timeline::where('stakeholder_id', stakeholder_id())->value('id');

            if(is_null($timeline_id)){
                $timeline_id = Timeline::create([
                    'stakeholder_id'=>stakeholder_id()
                ])->id;
            }

            $event = TimelineEvent::create([
                'timeline_id' => $timeline_id,
                'category_id' => $request->input('category_id'),
                'title' => $request->input('title'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'description' => $request->input('description'),
                'production_percentage' => $request->input('production_percentage'),
                'is_active' => $request->input('is_active')
            ]);

            $resources = $request->input("resources");

            foreach ($resources as $resource) {
                EventResources::create([
                    'event_id' => $event->id,
                    'resource_id' => $resource
                ]);
            }

            return api_response(message: 'event-creatting-success');
        } catch (Exception $e) {

            return api_response(errors: [$e->getMessage()], message: 'event-creatting-error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get timeline event by ID and check if existing
        try {

            // Title - Start Date - End Date - Description - Available Resources (Resource - Quantity) ) 
            $data = getAndCheckModelById(TimelineEvent::class, $id);

            $resources = $data->resources->map(function ($query) {
                return [
                    'resource_id' => $query->id,
                    'resource' => $query->resource,
                    'quantity' => $query->quantity
                ];
            });

            $data = [
                'title' => $data->title,
                'start_date' => $data->start_date,
                'end_date' => $data->end_date,
                'description' => $data->description,
                'resources' => $resources
            ];

            return api_response(data: $data, message: 'event-getting-success');
        } catch (NotFoundResourceException $e) {
            return api_response(errors: [$e->getMessage()], message: 'event-getting-success', code: 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(TimelineEventRequest $request, string $id)
    {
        // Get timeline event by ID and check if existing
        try {
            $validated_data = $request->validated();

            $data = getAndCheckModelById(TimelineEvent::class, $id);

            $data->update([
                'category_id' => $request->input('category_id'),
                'title' => $request->input('title'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'description' => $request->input('description'),
                'production_percentage' => $request->input('production_percentage'),
                'is_active' => $request->input('is_active')
            ]);

            $resources = $request->input("resources") ? $request->input("resources") : [];

            $existingResourceIds = $data->resources->pluck('id')->toArray();

            // Delete resources that are not in the updated list
            foreach ($existingResourceIds as $resourceId) {
                if (!in_array($resourceId, $resources)) {
                    $data->resources()->detach($resourceId);
                }
            }

            // Add new resources
            foreach ($resources as $resourceId) {
                if (!in_array($resourceId, $existingResourceIds)) {
                    EventResources::create([
                        'event_id' => $id,
                        'resource_id' => $resourceId
                    ]);
                }
            }

            return api_response(message: 'event-editing-success');
        } catch (NotFoundResourceException $e) {
            return api_response(errors: [$e->getMessage()], message: 'event-editing-error', code: 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get timeline event by ID and check if existing
        try {
            $data = getAndCheckModelById(TimelineEvent::class, $id);

            // Delete the associated resources first
            $data->resources()->detach();

            // Then delete the event
            $data->delete();

            return api_response(message: 'event-deleting-success');
        } catch (NotFoundResourceException $e) {
            return api_response(errors: [$e->getMessage()], message: 'event-deleting-error', code: 500);
        }
    }
}
