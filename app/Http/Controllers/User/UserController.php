<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notifications\Notification;
use App\Models\User;
use App\Notifications\PostsNotifications;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\api_response;
use function App\Helpers\fake_register_request;
use function App\Helpers\getAndCheckModelById;

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
                ->select('industrial_areas.id as industrial_area_id', 'users.id as user_id', 'industrial_areas.name as industrial_area_name',
                    'users.email', 'users.stakeholder_type', 'user_profiles.name as user_name')
                ->where(['industrial_areas.id' => $industrial_area_id])
                ->whereNull('users.deleted_at')->get();

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
     * Users in same subdomain 
     */
    public function same_subdomain_users()
    {

        try {
            
            // View Users list of the subdomain users (company name- email- account- industrial area- phone No.)
            // Get the industrial area id to get the users belongs to this industrial area
            $industrial_area_id = Auth::user()->stakeholder->industrial_area_id;

            // Get the users bleong to this subdomain
            $subdomain_users = User::select('up.name','users.email','sk.tenant_company_state as acount','ia.name as industrial_area','up.phone_number')
            ->join('user_profiles as up','users.id','=','up.user_id')
            ->join('stakeholders as sk','users.id','=','sk.user_id')
            ->join('industrial_areas as ia','sk.industrial_area_id','=','ia.id')
            ->where('ia.id',$industrial_area_id)->get();

            // return the result
            return api_response(data:$subdomain_users,message:'same-subdomain-users-getting-success');

        } catch (\Exception $e) {

            return api_response(errors:[$e->getMessage()],message:'same-subdomain-users-getting-error',code:500);

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
                'data' => $user_details,
                'message' => __('subdomain-user-details-success')
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('subdomain-user-details-error')
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
                'stakeholder_type' => 'required|string|in:Tenant_company,Infrastructure_provider,Government_representative',
                'location' => 'nullable|string|max:255'
            ]);

            // create industrial area representative (user)
            // Simulate a request to the RegisteredUserController@store method
            $response = fake_register_request(
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
                'message' => __('subdomain-user-add-error')
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
    public function destroy(string $id)
    {
        try {

            // get the user
            $user = getAndCheckModelById(User::class, $id);

            // remove the user
            $user->delete();

            return response()->json([
                'message' => __('subdomain-user-delete-success')
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('subdomain-user-delete-error')
            ], 500);

        }

    }
}
