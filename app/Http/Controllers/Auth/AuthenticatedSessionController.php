<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\Rules;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {

            $request->authenticate();

            // Delete all existing tokens for the authenticated user
            $request->user()->tokens()->delete();

            // Set the expiration time for the new token
            $expiresAt = Carbon::now()->addDays(30);

            // Get user details
            $user = $request->user();

            // Create a new token for the user
            $token = $user->createToken('login_token', ['*'], $expiresAt);

            // Return a JSON response with the token and user details
            return response()->json([
                'token' => $token->plainTextToken,
                'user' => $user,
                'message' => __('Login successful'),
            ], 200);

        } catch (AuthenticationException $e) {
            // Catch AuthenticationException and return an unauthorized response
            return response()->json([
                'error' => 'Unauthorized',
                'message' => __('Invalid credentials'),
            ], 401);

        } catch (ValidationException $e) {
            // Catch ValidationException and return a validation error response
            return response()->json([
                'error' => 'Validation Error',
                'message' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Change password
     */
    public function change_password(Request $request)
    {
        try{

            $request->validate([
                'current_password' => 'required',
                'new_password' =>  ['required', 'confirmed', Rules\Password::defaults()]
            ]);

            $user = Auth::user();

            $new_password = password_hash($request->input('new_password'),PASSWORD_DEFAULT);

            if($user->password == $new_password){

                return response()->json([
                    'message' => __('Your new password it same old password')
                ],400);

            }

            $user->password = $new_password;

            $user->save();

            return response()->json([
                'message' => __('Your password changed successfully')
            ],200);

        }
        catch (Exception $e){
            return \response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are')
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Revoke the user's access token
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => __('Logout successful'),
            ], 200);

        } catch (\Exception $e) {
            // Handle any exceptions that might occur during logout
            return response()->json([
                'error' => 'Logout Error',
                'message' => __('Unable to logout'),
            ], 500);
        }
    }

}
