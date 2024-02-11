<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        try {

            $users = User::with(['user_profile', 'stakeholder'])->get();

            return response()->json([
                'users' => $users
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are error try another time')
            ], 500);

        }

    }

    /**
     *  Get the subdomain users for subdomain industrial area
     */
    public function subdomain_users()
    {

        try {

            $industrial_area_id = Auth::user()->industrial_area_id;

            $subdomain_users = DB::table('industrial_areas')
                ->join('stakeholders', 'industrial_areas.id', '=', 'stakeholders.industrial_area_id')
                ->join('users', 'stakeholders.user_id', '=', 'users.id')
                ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                ->select('industrial_areas.id as id', 'users.id as user_id', 'industrial_areas.name as industrial_area_name',
                    'users.email', 'users.stakeholder_type', 'user_profiles.name as user_name')
                ->where('industrial_areas.id', '=', $industrial_area_id)->get();

            // return the result
            return response()->json([
                'data' => $subdomain_users,
                'message' => __('Successfully getting the subdomain users details')
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are problem in server side try another time')
            ], 500);
        }

    }


    /**
     * Get subdomain user details
     */
    public function subdomain_user_details(string $id)
    {
        try {

            $user_details = User::with(['user_profile', 'stakeholder'])
                ->findOrFail($id);
            return response()->json([
                'user_details' => $user_details
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are error try another time')
            ], 500);

        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store_new_subdomain_user(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:3',
                'phone_number' => 'nullable|string|max:20',
                'contact_person' => 'nullable|string|max:255',
                'stakeholder_type' => 'required|string|in:Tenant_company,Other_Stakeholder_Type',
                'location' => 'nullable|string|max:255'
            ]);

            // create industrial area representative (user)
            // Simulate a request to the RegisteredUserController@store method
            $response = \App\Helpers\fake_register_request(
                name: $validatedData['name'],
                email: $validatedData['email'],
                password: $validatedData['password'],
                password_confirmation: $validatedData['password'],
                phone_number: $validatedData['phone_number'],
                contact_person: $validatedData['contact_person'],
                stakeholder_type: $validatedData['stakeholder_type'],
                location: $validatedData['location']
            );

            return $response;

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are problem in server side try another time')
            ]);

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            // validate the user_id
            $request->validate([
                'user_id' => 'required|string|exists:users,id'
            ]);

            // get the user
            $user = User::findOrFail($request->input('user_id'));

            // remove the user
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'error' => 'User not found'
            ], 404);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Something went wrong'
            ], 500);

        }

    }
}
