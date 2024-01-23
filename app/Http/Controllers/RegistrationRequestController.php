<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Registration_request;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class RegistrationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{

            $this->authorize('view_all',Registration_request::class);

            $request->validate([
                'user_id' => 'string|exists:users,id'
            ]);

            // get all registration for industrial area representative
            $registration_requests = User::findOrFail($request->input('user_id'))->registration_requests;

            // return the data
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
            $validatedData=$request->validate([
                'user_id' => 'required|string|exists:users,id',
                'name' => 'required|string',
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
            $registration_request = Registration_request::create($validatedData);

            // Return a success response
            return response()->json([
                'request' => $registration_request,
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

            // validate request inputs
            $request->validate([
                'registration_id' => 'required|string|exists:registration_requests,id',
                'state' => 'required|boolean'
            ]);

            // store registration id to fetch the registration request to handle it (Accept or Refuse)
            $registration_id = $request->registration_id;

            // if state is 'true' accept the registration request, or refuse it
            $state = $request->state;

            // fetch the registration request
            $registration_request = Registration_request::findOrFail($registration_id);

            // check state
            if($state){

                // update request state to accept and message to your request accepted
                $registration_request->update([
                    'request_state' => __('accepted') ,
                    'failed_message' => __('your request accepted')
                ]);

                // Simulate a request to the RegisteredUserController@store method
                $request = Request::create('/api/register', 'POST', [
                    'user_id' => $registration_request->user_id,
                    'industrial_area_id' => '',
                    'name' => $registration_request->name,
                    'email' => $registration_request->email,
                    'password' => $registration_request->password,
                    'password_confirmation' => $registration_request->password,
                    'phone_number' => $registration_request->phone_number,
                    'contact_person' => null,
                    'stakeholder_type' => null,
                    'location' => $registration_request->location,
                    'representative_name' => $registration_request->representative_name,
                    'job_title' => $registration_request->job_title
                ]);

                // make an object of RegisteredUserController to use register user function ( store )
                $response = (new RegisteredUserController())->store($request);

                // Return a success response
                return $response;

            }else{

                // update the request state to failed if state is not true, and message to your request failed
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

