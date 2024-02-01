<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user_id = Auth::id();
            $employees = DB::table('users')
                ->join('stakeholders', 'users.id', '=', 'stakeholders.user_id')
                ->join('employees', 'stakeholders.id', '=', 'employees.stakeholder_id')
                ->join('residential_areas', 'employees.residential_area_id', '=', 'residential_areas.id')
                ->join('entities as department', 'employees.department_id', '=', 'department.id')
                ->join('entities as station', 'employees.station_id', '=', 'station.id')
                ->join('entities as route', 'employees.route_id', '=', 'route.id')
                ->select('employees.id', 'employees.employee_number as number', 'employees.is_leadership as leadership',
                    'residential_areas.name as residential_area_name', 'residential_areas.location as residential_area_location',
                    'department.name as department_name', 'station.name as station_name', 'route.name as route_name')->where('users.id','=',$user_id)
                ->get();

            return response()->json([
                'employees' => $employees,
                'message' => __('Successfully getting employees details')
            ],200);

        }
        catch (\Exception $e){

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there are error in server side try another time')
            ]);

        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            // Validate the request
            $request->validate([
                'employee_number' => 'required|integer|unique'.Employee::class,
                'department_id' => 'required|string|exists:entities,id',
                'station_id' => 'required|string|exists:entities,id',
                'route_id' => 'required|string|exists:entities,id',
                'residential_area_id' => 'required|string|exists:residential_areas,id',
                'is_leadership' => 'required|boolean'
            ]);

            $stakeholder_id = Auth::user()->stakeholder()->first()->id;

            // Create the employee
            $employee = Employee::create([
                'stakeholder_id' => $stakeholder_id,
                'employee_number' => $request->input('employee_number'),
                'department_id' => $request->input('department_id'),
                'station_id' => $request->input('station_id'),
                'route_id' => $request->input('route_id'),
                'residential_area_id' => $request->input('residential_area_id'),
                'is_leadership' => $request->input('is_leadership')
            ]);

            return nresponse()->json([
                'employee_data' => $employee,
                'message' => __('Successfully adding new employee')
            ],200);
        }
        catch (\Exception $e){
            return response()->json([
                'error' => __($e->getMessage())
            ]);
        }
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
