<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Registration_request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
                'user_id' => 'required|string|exists:users,id',
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
                'user_id' => $request->input('user_id'),
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
    public function accept_or_failed(Request $request)
    {
        try {

            $request->validate([
                'registration_id' => 'required|string|exists:registration_requests,id',
                'state' => 'required|boolean'
            ]);

            $registration_id = $request->registration_id;

            $state = $request->state;

            $registration_request = Registration_request::findOrFail($registration_id);

            if($state){

                $registration_request->update([
                    'request_state' => __('accepted') ,
                    'failed_message' => __('your request accepted')
                ]);
                // I have to complete it towmoro
                // Simulate a request to the RegisteredUserController@store method
                $response = Route::dispatch(Request::create('/api/register', 'POST', $registration_request->toArray()));

                // Return a success response
                return $response;

            }else{

                $registration_request->update([
                    'request_state' => __('failed') ,
                    'failed_message' => __('your request failed')
                ]);

                // Return a success response
                return response()->json([
                    'message' => __('Registration request refused'),
                ], 201); // 201 Created status code

            }

        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'error' => __('Error adding Registration request'),
                'message' => __($e->getMessage()),
            ], 500); // 500 Internal Server Error status code
        }
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
