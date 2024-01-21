<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    // create new subdomain account
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {

            // Validate the inputs
            $validatedData = $request->validate([
                'industrial_area_id' => ['exists:industrial_areas,id'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'phone_number' => ['required', 'string', 'regex:/^[0-9]{9,20}$/'],
                'contact_person' => ['required', 'string', 'max:50', 'min:3'],
                'stakeholder_type' => ['in:Tenant_company,Portal_manager,Industrial_area_representative,Infrastructure_provider,Government_representative'],
                'location' => ['string'],
                'representative_name' => ['string'],
                'job_title' => ['string']
            ]);

            // Create a new user
            $user = User::create([
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'stakeholder_type' => $validatedData['stakeholder_type']
            ]);

            // Create a new user profile
            $user_profile = User_profile::create([
                'user_id' => $user->id,
                'name' => $validatedData['name'],
                'contact_person' => $validatedData['contact_person'],
                'location' => $validatedData['location'],
                'phone_number' => $validatedData['phone_number']
            ]);

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
                    'user_profile'=> $user_profile,
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
