<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Industrial_area;
use App\Models\Stakeholder;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    // Create a new subdomain account
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {

            // Validate the inputs
            $validatedData = $request->validate([
                'industrial_area_id' => ['nullable', 'exists:industrial_areas,id'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone_number' => ['nullable','string', 'regex:/^[0-9]{9,20}$/'],
                'contact_person' => ['nullable', 'string', 'max:50', 'min:3'],
                'stakeholder_type' => ['nullable', 'in:Tenant_company,Portal_manager,Industrial_area_representative,Infrastructure_provider,Government_representative'],
                'location' => ['string'],
                'representative_name' => ['nullable','string'],
                'job_title' => ['nullable','string']
            ]);

            // Create a new user
            $user = User::create([
                'industrial_area_id' => $validatedData['industrial_area_id'],
                'email' => $validatedData['email'],
                'password' => password_hash($validatedData['password'],PASSWORD_DEFAULT),
                'stakeholder_type' => $validatedData['stakeholder_type'] == null ? 'Tenant_company' : $validatedData['stakeholder_type']
            ]);

            // Create a new user profile
            $user_profile = User_profile::create([
                'user_id' => $user->id,
                'name' => $validatedData['name'],
                'contact_person' => $validatedData['contact_person'] == null ? '' : $validatedData['contact_person'],
                'location' => $validatedData['location'],
                'phone_number' => $validatedData['phone_number'] ? $validatedData['phone_number'] : '0000000000'
            ]);

            // check if this fields is empty return response with user and user profile because this user is not stakeholder
            if (empty($validatedData['phone_number']) && empty($validatedData['contact_person']) && empty($validatedData['representative_name']) && empty($validatedData['job_title'])) {

                return response()->json(
                    [
                        'user' => $user,
                        'user_profile' => $user_profile,
                        'message' => __('User created successfully')
                    ], 200);

            }

            // If industrial_area_id is not provided, fetch it by user_id because the relation between users and industrials_areas is on to on
            if (empty($validatedData['industrial_area_id'])) {
                $validatedData['industrial_area_id'] = Auth::user()->industrial_area_id;
            }else{
                return response()->json([
                    'message'=> __('failed to create stakeholder')
                ],500);
            }

            // Create a new stakeholder
            $stakeholder = Stakeholder::create([
                'user_id' => $user->id,
                'industrial_area_id' => $validatedData['industrial_area_id'],
                'company_representative_name' => $validatedData['representative_name'],
                'job_title' => $validatedData['job_title'],
            ]);

            return response()->json(
                [
                    'user' => $user,
                    'user_profile' => $user_profile,
                    'stakeholder' => $stakeholder,
                    'message' => __('User created successfully')
                ], 200);

        } catch (\Exception $e) {
            // Handle any exceptions that may occur during the process
            return response()->json(
                [
                    'error' => __('Error occurred during user creation'),
                    'message' => __($e->getMessage())
                ], 500);
        }
    }
}
