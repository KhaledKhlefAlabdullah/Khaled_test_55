<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceValidationRequest;
use App\Models\Service;
use App\Models\Stakeholder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            // todo i have to edite it when i get answer on question 22

            $industrial_area_id = Auth::user()->industrial_area_id;

            $seveices = DB::table('user_profiles')
                ->join('users', 'user_profiles.user_id', '=', 'users.id')
                ->join('stakeholders', 'users.id', '=', 'stakeholders.user_id')
                ->join('services', 'stakeholders.id', '=', 'services.stakeholder_id')
                ->join('categories', 'services.category_id', '=', 'categories.id')
                ->select('services.id as service_id', 'categories.id as category_id',
                    'categories.name as category_name', 'user_profiles.name as provider_name')
                ->where('stakeholders.industrial_area_id', '=', $industrial_area_id)->get();

            return response()->json([
                'data' => $seveices,
                'message' => __('Successfully fetching the services')
            ], 200);
        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in server side')
            ], 500);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'stakeholder_id' => 'required|string|exists:stakeholders,id',
                'category_id' => 'required|string|exists:categories,id',
                'infrastructures_state' => 'required|in:available,partially,interrupted',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date'
            ]);

            $service = Service::create($validatedData);

            return response()->json([
                'service' => $service,
                'message' => __('Successfully create new service')
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are error in server side')
            ]);

        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'infrastructures_state' => 'required|in:available,partially,interrupted',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date'
            ]);


            $service = Service::findOrFail($request->input('id'));

            $service->update($validatedData);

            return response()->json([
                'service after update' => $service,
                'message' => __('Successfully update service')
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are error in server side')
            ]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }
}
