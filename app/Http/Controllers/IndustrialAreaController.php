<?php

namespace App\Http\Controllers;

use App\Models\IndustrialArea;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use function App\Helpers\fake_register_request;

class IndustrialAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            // get all industrial areas in database
            $industrial_areas = IndustrialArea::all();

            // check if their industrial areas in database
            if ($industrial_areas->isNotEmpty()) {

                // return the data
                return response()->json([
                    'industrial_areas' => $industrial_areas,
                    'message' => __('Successfully request')
                ], 201);

            }

            return response()->json([
                'message' => __('Successfully request but there now industrial areas in database yeet')
            ], 402);

        } // handling the exceptions
        catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('Failed to get any thing')
            ], 501);

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // validate the inputs data
            $request->validate([
                'name' => ['required', 'string', 'min:5'],
                'address' => ['required', 'string'],
                'representative_name' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class]
            ]);

            // create new industrial area
            $industrial_area = IndustrialArea::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
            ]);

            // create industrial area representative (user)
            // Simulate a request to the RegisteredUserController@store method
            $response = fake_register_request(
                industrial_area_id: $industrial_area->id,
                name: $request->input('representative_name'),
                email: $request->input('email'),
                password: 'P@ssword',
                password_confirmation: 'P@ssword',
                stakeholder_type: 'Industrial_area_representative',
                location: $industrial_area->address
            );

            return $response;
        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there ara problem, some thing went wrong')
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|string|exists:industrial_areas,id'
            ]);

            // get all industrial areas in database
            $industrial_area = IndustrialArea::findOrFail($request->input('id'))->with('user')->get();

            // check if their industrial areas in database
            if (!empty($industrial_area)) {

                // return the data
                return response()->json([
                    'industrial_area' => $industrial_area,
                    'message' => __('Successfully request')
                ], 201);

            }

            return response()->json([
                'message' => __('Successfully request but there now industrial areas in database yeet')
            ], 402);

        } // handling the exceptions
        catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('Failed to get any thing')
            ], 501);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {

            // validate the inputs data
            $request->validate([
                'id' => 'required|string|exists:industrial_areas,id',
                'name' => ['required', 'string', 'min:5'],
                'address' => ['required', 'string'],
                //'representative_name' => ['required','string'],
                //'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class]
            ]);

            // get the industrial area want to edite
            $industrial_area = IndustrialArea::findOrFail($request->input('id'));

            // create new industrial area
            $industrial_area->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
            ]);

            return response()->json([
                'industrial_area' => $industrial_area,
                'message' => __('successfully editing industrial area details')
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there ara problem, some thing went wrong')
            ]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndustrialArea $industrial_area)
    {
        //
    }
}
