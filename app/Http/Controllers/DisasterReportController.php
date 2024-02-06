<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterReportRequest;
use App\Http\Resources\DisasterReportResource;
use App\Models\DisasterReport;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;

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
        // Get the category by ID and check if it exists
        try {
            $disaster_report = getAndCheckModelById(DisasterReport::class, $id);

            // Return the report
            return new DisasterReportResource($disaster_report);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DisasterReportRequest $request, string $id)
    {
        // Get the category by ID and check if it exists
        try {
            $disaster_report = getAndCheckModelById(DisasterReport::class, $id);

            // Validate the request
            $valid_data = $request->validated();

            // Update the disaster report
            $disaster_report->update($valid_data);

            return new DisasterReportResource($disaster_report);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the category by ID and check if it exists
        try {
            $disaster_report = getAndCheckModelById(DisasterReport::class, $id);

            // Delete the disaster report
            $disaster_report->delete();

            return response()->json([
                'message' => 'Report deleted successfully',
            ]);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }


    }
}
