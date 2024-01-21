<?php

namespace App\Http\Controllers;

use App\Models\Registration_request;
use Illuminate\Http\Request;


class RegiatrationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{

            $registration_requests =Registration_request::all();
            return response()->json([
                'registration requests' => $registration_requests,
                'message' => __('Get all registration requests successfully'),
            ], 200);

        }catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'error' => __('Error in get all registration requests'),
                'message' => __($e->getMessage()),
            ], 500); // 500 Internal Server Error status code
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'stakeholder_id' => 'required|string',
                'company_name' => 'required|string',
                'representative_name' => 'required|string',
                'email' => 'required|email|unique:registration_requests',
                'password' => 'required|string',
                'location' => 'required|string',
                'phone_number' => 'required|string',
                'job_title' => 'required|string',
                'request_state' => 'required|in:accepted,failed,pending',
                'failed_message' => 'nullable|string'
            ]);

            // Create a new stakeholder using Eloquent
            Registration_request::create([
                'stakeholder_id' => $request->input('stakeholder_id'),
                'company_name' => $request->input('company_name'),
                'representative_name' => $request->input('representative_name'),
                'email' => $request->input('email'),
                'password' => password_hash($request->input('password'),PASSWORD_DEFAULT),
                'location' => $request->input('location'),
                'phone_number' => $request->input('phone_number'),
                'job_title' => $request->input('job_title'),
                'request_state' => $request->input('request_state'),
                'failed_message' => $request->input('failed_message'),
            ]);

            // Return a success response
            return response()->json([
                'message' => __('Registration request added successfully'),
            ], 201); // 201 Created status code
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'error' => __('Error adding Registration request'),
                'message' => __($e->getMessage()),
            ], 500); // 500 Internal Server Error status code
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            // Get the registration request from the request
            $registration_id = $request->input('registration_id');

            // Delete the stakeholder
            Registration_request::findOrFail($registration_id)->delete();

            return response()->json([
                'message' => __('Registration request deleted successfully')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __('Registration request deletion failed'),
                'message' => __($e->getMessage())
            ], 500);
        }
    }
}
