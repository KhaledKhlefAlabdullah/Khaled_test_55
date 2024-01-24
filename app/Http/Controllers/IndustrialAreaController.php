<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Industrial_area;
use App\Models\User;
use Illuminate\Http\Request;

class IndustrialAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            // get all industrial areas in database
            $industrial_areas = Industrial_area::all();

            // check if their industrial areas in database
            if($industrial_areas->isNotEmpty()){

                // return the data
                return response()->json([
                    'industrial_areas' => $industrial_areas,
                    'message' => __('Successfully request')
                ],201);

            }

            return response()->json([
                'message' => __('Successfully request but there industrial areas in database yeet')
            ],402);

        }
        // handling the exceptions
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message'=> __('Failed to get any thing')
            ],501);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{

            // validate the inputs data
            $request->validate([
                'name' => ['required','string','min:5'],
                'address' => ['required','string'],
                'representative_name' => ['required','string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class]
            ]);

            // create new industrial area
            $industrial_area = Industrial_area::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
            ]);

            // create industrial area representative (user)
            // Simulate a request to the RegisteredUserController@store method
            $request = Request::create('/api/register', 'POST', [
                'user_id' => null,
                'industrial_area_id' => $industrial_area->id,
                'name' => $request->input('representative_name'),
                'email' => $request->input('email'),
                'password' => 'P@ssword',
                'password_confirmation' => 'P@ssword',
                'phone_number' => null,
                'contact_person' => null,
                'stakeholder_type' => 'Industrial_area_representative',
                'location' => $industrial_area->address,
                'representative_name' => null,
                'job_title' => null
            ]);

            // make an object of RegisteredUserController to use register user function ( store )
            $response = (new RegisteredUserController())->store($request);

            return $response;

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there ara problem, some thing went wrong')
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Industrial_area $industrial_area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industrial_area $industrial_area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Industrial_area $industrial_area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industrial_area $industrial_area)
    {
        //
    }
}
