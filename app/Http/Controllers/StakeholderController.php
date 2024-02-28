<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use Dflydev\DotAccessData\Exception\DataException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use PHPUnit\Exception;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class StakeholderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $stakeholders = Stakeholder::all();

            return response()->json(['stakeholders'=>$stakeholders],200);
        }
        catch (NotFound $e) {
            // Catch ValidationException and return a validation error response
            return response()->json([
                'error' => __('Not Found Error'),
                'message' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {

        try{

            // validate the inputs
            $request->validate([
                'user_id' => 'required|string',
                'industrial_area_id' => 'required|string',
                'parent_id' => 'nullable|string',
                'representative_government_agency' => 'nullable|string',
                'tenant_company_state' => 'nullable|in:operating,evacuating,trapped,evacuated',
                'company_representative_name' => 'nullable|string',
                'job_title' => 'nullable|string',
                'infrastructures_state' => 'nullable|in:available,partially,interrupted',
                'infrastructure_type' => 'nullable|string',
            ]);

            // create new stakeholder with validate inputs
            $stakeholder = Stakeholder::create([
                'user_id' => $request->input('user_id'),
                'industrial_area_id' => $request->input('industrial_area_id'),
                'parent_id' => $request->input('parent_id'),
                'representative_government_agency' => $request->input('representative_government_agency'),
                'tenant_company_state' => $request->input('tenant_company_state'),
                'company_representative_name' => $request->input('company_representative_name'),
                'job_title' => $request->input('job_title'),
                'infrastructures_state' => $request->input('infrastructures_state'),
                'infrastructure_type' => $request->input('infrastructure_type'),
            ]);

            // return response with successfully state if operation don
            return response()->json([
                'message' => __('Stakeholder added successfully'),
                'stakeholder' => $stakeholder,
            ], 201);
        }
        catch (ValidationException $e) {
            // Catch ValidationException and return a validation error response
            return response()->json([
                'error' => __('Validation Error'),
                'message' => $e->errors(),
            ], 422);
        }
        catch (Exception $e){
            return response()->json([
                'error' => __('Error in create'),
                'message' => $e->errors(),
            ], 520);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Stakeholder $staheholder)
    {
        //
    }

    /**
     * edit company status.
     */
    public function edit_company_state(Request $request)
    {
        try {
            // validate the new company state
            $request->validate([
                'new_company_status' => 'required|string|in:operating,evacuating,trapped,evacuated'
            ]);

            // get auth user to get company details (stakeholder)
            $user = Auth::user();

            // get the stakeholder and update company state
            $user->stakeholder()->update([
                'tenant_company_state' => $request->input('new_company_status')
            ]);

            // store the new state to return it
            $new_company_state = $user->stakeholder()->get();

            // return json response with new company state
            return response()->json([
                'new_tenant_company_state' => $new_company_state,
                'message' => __('Successfully editing company state')
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There error in server side try another time')
            ],500);

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            // Validate the inputs
            $validatedData = $request->validate([
                'user_id' => 'required|string',
                'parent_id' => 'nullable|string',
                'representative_government_agency' => 'nullable|string',
                'tenant_company_state' => 'nullable|in:operating,evacuating,trapped,evacuated',
                'company_representative_name' => 'nullable|string',
                'job_title' => 'nullable|string',
                'infrastructures_state' => 'nullable|in:available,partially,interrupted',
                'infrastructure_type' => 'nullable|string',
            ]);

            $request->validate([
                'stakeholder_id'=>'required|string'
            ]);

            $stakeholder_id = $request->stakeholder_id;

            // Find the stakeholder by ID
            $stakeholder = Stakeholder::findOrFail($stakeholder_id);

            // Update the stakeholder with validated inputs
            $stakeholder->update($validatedData);

            // Return response with success state if the operation is done
            return response()->json([
                'message' => __('Stakeholder updated successfully'),
                'stakeholder' => $stakeholder,
            ], 200);
        } catch (ValidationException $e) {
            // Catch ValidationException and return a validation error response
            return response()->json([
                'error' => __('Validation Error'),
                'message' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => __('Error in update'),
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {

            // Get the stakeholderId from the request
            $stakeholder_id = $request->input('stakeholder_id');

            // delete the stakeholder
            Stakeholder::findOrFail($stakeholder_id)->delete();

            return response()->json([
                'message'=>__('stakeholder deleted successfully')
            ],200);
        }catch (\Exception $e){
            return response()->json([
                'message'=>__('stakeholder deleted failed')
            ],500);
        }
    }
}
