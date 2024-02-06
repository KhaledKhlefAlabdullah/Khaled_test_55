<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceValidationRequest;
use App\Models\Service;
use App\Models\Stakeholder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            // todo i have to edite it when i get answer on question 22

            $industrial_area_id = Auth::user()->industrial_area_id;

            $stakeholders = Stakeholder::where('industrial_area_id', $industrial_area_id)->with('services')->get();

            $services = Service::all();

            return response()->json([
                'services' => $services,
                '$stakeholders' => $stakeholders,
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
                'slug' => 'required|string',
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
                'slug' => 'required|string',
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
