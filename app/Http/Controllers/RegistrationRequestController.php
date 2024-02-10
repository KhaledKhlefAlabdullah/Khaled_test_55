<?php

namespace App\Http\Controllers;

use App\Models\IndustrialArea;
use App\Models\RegistrationRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\fake_register_request;
use function App\Helpers\send_mail;


class RegistrationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            // get authenticated user id
            $industrial_area_id = Auth::user()->industrial_area_id;

            // get all registration for industrial area representative
            $registration_requests = IndustrialArea::findOrFail($industrial_area_id)->registration_requests;

            // return the data
            return response()->json([
                'data' => $registration_requests,
                'message' => __('Get all registration requests successfully'),
            ], 200);

        } catch (Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'error' => __('Error in get all registration requests'),
                'message' => __($e->getMessage()),
            ], 500); // 500 Internal Server Error status code
        }
    }

    /**
     * Display a request details.
     */
    public function show(Request $request)
    {
        try {

            // get authenticated user id
            $industrial_area_id = Auth::user()->industrial_area_id;

            // get registration request id from api request
            $registration_id = $request->registration_id;

            // get all registration for industrial area representative
            $registration_request = RegistrationRequest::where(['id' => $registration_id, 'industrial_area_id' => $industrial_area_id])->first();

            // return the data
            return response()->json([
                'data' => $registration_request,
                'message' => __('Get registration request details successfully'),
            ], 200);

        } catch (Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'error' => __('Error in get registration request details'),
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
            $validatedData = $request->validate([
                'industrial_area_id' => 'required|string|exists:industrial_areas,id',
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
            $registration_request = RegistrationRequest::create($validatedData);

            // Return a success response
            return response()->json([
                'request' => $registration_request,
                'message' => __('Registration request added successfully'),
            ], 201); // 201 Created status code
        } catch (Exception $e) {
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
    public function accept_or_failed(Request $request, string $id)
    {
        try {

            // validate request inputs
            $request->validate([
                'state' => 'required|boolean'
            ]);

            // if state is 'true' accept the registration request, or refuse it
            $state = $request->state;

            // fetch the registration request
            $registration_request = RegistrationRequest::findOrFail($id);

            // check state
            if ($state) {

                // update request state to accept and message to your request accepted
                $registration_request->update([
                    'request_state' => __('accepted'),
                    'failed_message' => __('your request accepted')
                ]);

                // create industrial area representative (user)
                // Simulate a request to the RegisteredUserController@store method
                $response = fake_register_request(
                    name: $registration_request->name,
                    email: $registration_request->email,
                    password: $registration_request->password,
                    password_confirmation: $registration_request->password,
                    phone_number: $registration_request->phone_number,
                    location: $registration_request->location,
                    representative_name: $registration_request->representative_name,
                    job_title: $registration_request->job_title
                );

                $mail_message = __('your registration request accepted and your password is:'.$registration_request->password);

            } else {

                // update the request state to failed if state is not true, and message to your request failed
                $registration_request->update([
                    'request_state' => __('failed'),
                    'failed_message' => __('your request failed')
                ]);

                $mail_message = __('your registration request refused');

                // Return a success response
                $response = response()->json([
                    'message' => __('Registration request refused'),
                ], 201); // 201 Created status code

            }

            $email = $registration_request->email;

            // send email to registration
            send_mail($mail_message,$email);

            return $response;

        } catch (Exception $e) {
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
            RegistrationRequest::findOrFail($registration_id)->delete();

            return response()->json([
                'message' => __('Registration request deleted successfully')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => __('Registration request deletion failed'),
                'message' => __($e->getMessage())
            ], 500);
        }
    }
}

