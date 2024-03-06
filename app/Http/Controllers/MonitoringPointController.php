<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonitoringPointRequest;
use App\Http\Requests\MonitorinPoints\MainMonitoringPointRequest;
use App\Http\Resources\MonitoringPointResource;
use App\Models\MonitoringPoint;
use App\Models\User;
use App\Policies\User_policies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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

    /**
     * View all monitoring points belongs to user
     */
    public function view_monitoring_points()
    {
        try {

            $user_id = Auth::id();

            $monitoring_points = MonitoringPoint::where('user_id', $user_id)
                ->select('monitoring_points.id', 'monitoring_points.name', 'monitoring_points.location',
                    'monitoring_points.point_type', 'monitoring_points.api_link')->get();

            return response()->json([
                'data' => $monitoring_points,
                'message' => __('monitoring-get-success')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('monitoring-get-error')
            ], 500);
        }
    }

    /**
     *
     * Add main monitoring point
     */
    public function add_monitoring_point(MainMonitoringPointRequest $request)
    {
        try {

            // get auth user is
            $user_id = Auth::id();

            $policy = new User_policies();

            // create new main monitoring point
            MonitoringPoint::create([
                'user_id' => $user_id,
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'point_type' => $request->input('level'),
                'API_link' => $request->input('api_link'),
                'is_custom' => $policy->infrastructure_provider_or_tenant_company(Auth::user())
            ]);

            // return response with success message
            return response()->json([
                'message' => __('main-monitoring-point-success')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('main-monitoring-point-error')
            ], 500);
        }
    }

    /**
     * edit monitoring point details
     */
    public function edit_monitoring_point_details(MainMonitoringPointRequest $request, string $id)
    {
        try {

            // get the monitoring point by id
            $monitoring_point = MonitoringPoint::find($id);

            // update the monitoring point details
            $monitoring_point->update([
                'name' => $request->input('name'),
                'location' => $request->input('location'),
                'point_type' => $request->input('level'),
                'API_link' => $request->input('api_link'),
            ]);

            // return response with success message
            return response()->json([
                'message' => __('monitoring-edit-success')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('monitoring-edit-error')
            ], 500);
        }
    }
}
