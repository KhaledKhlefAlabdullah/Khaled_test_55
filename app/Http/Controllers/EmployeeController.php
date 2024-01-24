<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Stakeholder;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all the employees of the stakeholder relationship
        $employees = Stakeholder::with('employees')->get();

        return ($employees->count() == 1)
            ? new EmployeeResource($employees->first)
            : EmployeeResource::collection($employees);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        // Validate the request
        $valid_data = $request->validated();

        // Create the employee
        $employee = Employee::create($valid_data);

        return new EmployeeResource($employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get the employee by ID
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return new EmployeeResource($employee);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        // Get the employee by ID
        $employee = Employee::find($id);

        // Check if the employee exists
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        // Validate the request
        $valid_data = $request->validated();

        // Update the employee
        $employee->update($valid_data);

        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get the employee by ID
        $employee = Employee::find($id);

        // Check if the employee exists
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        // Delete the employee
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
