<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Extract credentials from the request
            $credentials = $request->only('email', 'password');

            // Attempt to authenticate the user
            if (!auth()->attempt($credentials)) {
                // Throw ValidationException if authentication fails
                throw ValidationException::withMessages([
                    'email' => [trans('auth.failed')],
                ]);
            }

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
     * Destroy an authenticated session.
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
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
