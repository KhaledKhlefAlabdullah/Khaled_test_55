<?php

namespace App\Http\Controllers;

use App\Models\IndustrialArea;
use App\Models\RegistrationRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function App\Helpers\fake_register_request;
use function App\Helpers\getAndCheckModelById;
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
            //View list of registration requests (Company Name - Representative Name - Email - Phone No.-Job Title)
            // get all registration for industrial area representative
            $registration_requests = RegistrationRequest::where(['industrial_area_id' => $industrial_area_id, 'request_state' => 'pending'])
                ->select('registration_requests.id as id', 'registration_requests.name as company_name',
                    'registration_requests.representative_name as representative_name',
                    'registration_requests.email', 'registration_requests.phone_number',
                    'registration_requests.job_title')->get();

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
    public function show(string $id)
    {
        try {

            // get authenticated user id
            $industrial_area_id = Auth::user()->industrial_area_id;
            // get all registration for industrial area representative
            $registration_request = RegistrationRequest::where(['id' => $id, 'industrial_area_id' => $industrial_area_id])
                ->select('registration_requests.id as id', 'registration_requests.name as company_name',
                    'registration_requests.representative_name as representative_name',
                    'registration_requests.email', 'registration_requests.phone_number',
                    'registration_requests.job_title')->first();


            if (is_null($registration_request))
                return response()->json([
                    'message' => __('Get registration request details failed there no item with this id'),
                ], 404);

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
                'state' => 'required|boolean',
            ]);

            // if state is 'true' accept the registration request, or refuse it
            $state = $request->state;

            // fetch the registration request
            $registration_request = RegistrationRequest::findOrFail($id);

            $registration_request_id = $registration_request->id;

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

                $request->validate([
                    'message' => 'required|string'
                ]);

                // update the request state to failed if state is not true, and message to your request failed
                $registration_request->update([
                    'request_state' => __('failed'),
                    'failed_message' => __('your request failed')
                ]);

                $mail_message = $request->input('message');

                // Return a success response
                $response = response()->json([
                    'message' => __('Registration request refused'),
                ], 201); // 201 Created status code

            }

            $email = $registration_request->email;

            // send email to registration
            send_mail($mail_message,$email);

            $this->destroy($registration_request_id);

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
    public function destroy(string $id)
    {
        try {

            $registration_request = getAndCheckModelById(RegistrationRequest::class, $id);

            $registration_request->delete();

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

