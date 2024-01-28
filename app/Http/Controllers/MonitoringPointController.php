<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonitoringPointRequest;
use App\Http\Resources\MonitoringPointResource;
use App\Models\MonitoringPoint;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class MonitoringPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all monitoring points
        $monitoring_points = MonitoringPoint::all();

        return transformCollection($monitoring_points, MonitoringPointResource::class);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MonitoringPointRequest $request)
    {
        // Validate the data
        $valid_data = $request->validated();

        // Create the monitoring point
        $monitoring_point = MonitoringPoint::create($valid_data);

        return new MonitoringPointResource($monitoring_point);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = getAndCheckModelById(MonitoringPoint::class, $id);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return new MonitoringPointResource($data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(MonitoringPointRequest $request, string $id)
    {
        // Get the monitoring point by ID
        try {
            $monitoring_point = getAndCheckModelById(MonitoringPoint::class, $id);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Validate the data
        $valid_data = $request->validated();

        // Update the monitoring point
        $monitoring_point->update($valid_data);

        return new MonitoringPointResource($monitoring_point);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $monitoring_point = getAndCheckModelById(MonitoringPoint::class, $id);

        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the monitoring point
        $monitoring_point->delete();

        return response()->json(['message' => 'Monitoring point deleted successfully']);
    }
}
