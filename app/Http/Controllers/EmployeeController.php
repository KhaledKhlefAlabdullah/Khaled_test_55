<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Stakeholder;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\transformCollection;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all the employees of the stakeholder relationship
        $employees = Stakeholder::with('employees')->get();


        return transformCollection($employees, EmployeeResource::class);
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
        // Get the employee by ID and check if it exists
        try {
            $employee = getAndCheckModelById(Employee::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return new EmployeeResource($employee);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        // Get the employee by ID and check if it exists
        try {
            $employee = getAndCheckModelById(Employee::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
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
        // Get the employee by ID and check if it exists
        try {
            $employee = getAndCheckModelById(Employee::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the employee
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
