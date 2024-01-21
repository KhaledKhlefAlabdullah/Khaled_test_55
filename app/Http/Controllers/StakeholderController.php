<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use Dflydev\DotAccessData\Exception\DataException;
use Illuminate\Http\Request;
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
                'parent_id' => 'nullable|string',
                'representative_government_agency' => 'nullable|string',
                'tent_company_state' => 'nullable|in:operating,evacuating,trapped,evacuated',
                'company_representative_name' => 'nullable|string',
                'job_title' => 'nullable|string',
                'infrastructures_state' => 'nullable|in:available,partially,interrupted',
                'infrastructure_type' => 'nullable|string',
            ]);

            // create new stakeholder with validate inputs
            $stakeholder = Stakeholder::create([
                'user_id' => $request->input('user_id'),
                'parent_id' => $request->input('parent_id'),
                'representative_government_agency' => $request->input('representative_government_agency'),
                'tent_company_state' => $request->input('tent_company_state'),
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
    public function show(Stahekolder $staheholder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stahekolder $staheholder)
    {
        //
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
                'tent_company_state' => 'nullable|in:operating,evacuating,trapped,evacuated',
                'company_representative_name' => 'nullable|string',
                'job_title' => 'nullable|string',
                'infrastructures_state' => 'nullable|in:available,partially,interrupted',
                'infrastructure_type' => 'nullable|string',
            ]);

            $request->validate([
                'stakeholder_id'=>'required|string'
            ]);

            // Find the stakeholder by ID
            $stakeholder = Stakeholder::findOrFail($request->stakeholder_id);

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
