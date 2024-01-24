<?php

namespace App\Http\Controllers;

use App\Models\Industrial_area;
use App\Models\Stakeholder;
use App\Models\User;
use App\Policies\User_policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        try{

            $users = User::with(['user_profile','stakeholder'])->get();

            return response()->json([
                'users' => $users
            ],200);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are error try another time')
            ],500);

        }

    }

    /**
     *  Get the subdomain users for subdomain industrial area
     */
    public function subdomain_users()
    {

        try {

            // get all stakeholders belong to industrial area
            $subdomain_users = Auth::user()->industrial_area()->with(['stakeholders','user'])->get();

            // return the result
            return response()->json([
                'subdomain_users' => $subdomain_users
            ],200);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are problem in server side try another time')
            ],500);
        }

    }


    /**
     * Get subdomain user details
     */
    public function subdomain_user_details(Request $request)
    {
        try{

            $request->validate([
                'user_id' => 'required|string|exists:users,id'
            ]);

            $user_details = User::with(['user_profile', 'stakeholder'])
                ->findOrFail($request->input('user_id'));
            return response()->json([
                'user_details' => $user_details
            ],200);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are error try another time')
            ],500);

        }

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store_new_subdomain_user(Request $request)
    {
        try{

            $validatedData = $request->validate([

            ]);

        }
        catch (\Exception $e){

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
