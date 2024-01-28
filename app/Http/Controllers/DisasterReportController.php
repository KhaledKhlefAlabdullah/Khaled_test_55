<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterReportRequest;
use App\Http\Resources\DisasterReportResource;
use App\Models\DisasterReport;

class DisasterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all the disaster reports
        $disaster_reports = DisasterReport::paginate();


        return $disaster_reports->count() == 1 ?
            new DisasterReportResource($disaster_reports->first()) : // return only one disaster report
            DisasterReportResource::collection($disaster_reports); // return all disaster reports
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(DisasterReportRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the disaster report
        $disaster_report = DisasterReport::create($valid_data);

        return new DisasterReportResource($disaster_report);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get Report by ID
        $disaster_report = DisasterReport::find($id);

        // Check if the report exists
        if (!$disaster_report) {
            return response()->json([
                'message' => 'Report not found'
            ], 404);
        }

        // Return the report
        return new DisasterReportResource($disaster_report);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(DisasterReportRequest $request, string $id)
    {
        // Get Disaster Report by ID
        $disaster_report = DisasterReport::find($id);

        // Check if the report exists
        if (!$disaster_report) {
            return response()->json([
                'message' => 'Report not found'
            ], 404);
        }

        // Validate the request
        $valid_data = $request->validated();

        // Update the disaster report
        $disaster_report->update($valid_data);

        return new DisasterReportResource($disaster_report);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get Disaster Report by ID
        $disaster_report = DisasterReport::find($id);

        // Check if the report exists
        if (!$disaster_report) {
            return response()->json([
                'message' => 'Report not found'
            ], 404);
        }

        // Delete the disaster report
        $disaster_report->delete();

        return response()->json([
            'message' => 'Report deleted successfully'
        ]);
    }
}
