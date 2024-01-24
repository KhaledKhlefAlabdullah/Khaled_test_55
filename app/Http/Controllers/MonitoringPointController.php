<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonitoringPointRequest;
use App\Http\Resources\MonitoringPointResource;
use App\Models\Monitoring_point;

class MonitoringPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all monitoring points
        $monitoring_points = Monitoring_point::all();

        return ($monitoring_points->count() == 1)
            ? new MonitoringPointResource($monitoring_points->first())
            : MonitoringPointResource::collection($monitoring_points);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MonitoringPointRequest $request)
    {
        // Validate the data
        $valid_data = $request->validated();

        // Create the monitoring point
        $monitoring_point = Monitoring_point::create($valid_data);

        return new MonitoringPointResource($monitoring_point);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the monitoring point by ID
        $monitoring_point = Monitoring_point::find($id);

        if (!$monitoring_point) {
            return response()->json(['message' => 'Monitoring point not found'], 404);
        }

        return new MonitoringPointResource($monitoring_point);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(MonitoringPointRequest $request, string $id)
    {
        // Get the monitoring point by ID
        $monitoring_point = Monitoring_point::find($id);

        if (!$monitoring_point) {
            return response()->json(['message' => 'Monitoring point not found'], 404);
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
        // Get the monitoring point by ID
        $monitoring_point = Monitoring_point::find($id);

        if (!$monitoring_point) {
            return response()->json(['message' => 'Monitoring point not found'], 404);
        }

        // Delete the monitoring point
        $monitoring_point->delete();

        return response()->json(['message' => 'Monitoring point deleted successfully']);
    }
}
