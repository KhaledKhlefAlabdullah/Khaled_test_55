<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Entity;
use App\Models\Residential_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Exception;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIdByName;
use function App\Helpers\stakeholder_id;

class EmployeeController extends Controller
{

    /**
     * Get employees data fot tenant company or infrastructure provider
     */
    private function get_employees()
    {
        try {

            //$user_id = Auth::id();

            $employees = DB::table('users')
                ->join('stakeholders', 'users.id', '=', 'stakeholders.user_id')
                ->join('employees', 'stakeholders.id', '=', 'employees.stakeholder_id')
                ->join('residential_areas', 'employees.residential_area_id', '=', 'residential_areas.id')
                ->join('entities as department', 'employees.department_id', '=', 'department.id')
                ->join('entities as station', 'employees.station_id', '=', 'station.id')
                ->join('entities as route', 'employees.route_id', '=', 'route.id')
                ->select('employees.id', 'employees.employee_number as number', 'employees.is_leadership as leadership',
                    'residential_areas.name as residential_area_name', 'residential_areas.location as residential_area_location',
                    'department.name as department_name', 'station.name as station_name', 'route.name as route_name')->where('users.id', '=', '12c97a6d-7b19-4fa9-a77f-2a76172f5b58')
                ->get();

            return $employees;
        } catch (Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there are error in server side try another time')
            ]);
        }

    }

    /**
     * Create employee
     */
    private function create_emplyee(
        $employee_number,
        $department_id,
        $station_id,
        $route_id,
        $residential_area_id,
        $is_leadership
    )
    {
        try {

            $stakeholder_id = stakeholder_id();

            // Create the employee
            $employee = Employee::create([
                'stakeholder_id' => $stakeholder_id,
                'employee_number' => $employee_number,
                'department_id' => $department_id,
                'station_id' => $station_id,
                'route_id' => $route_id,
                'residential_area_id' => $residential_area_id,
                'is_leadership' => $is_leadership
            ]);

            return $employee;
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there are error in server side try another time')
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $employees = $this->get_employees();

            return response()->json([
                'employees' => $employees,
                'message' => __('Successfully getting employees details')
            ], 200);

        } catch (\Exception $e) {

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
        try {
            // Validate the request
            $request->validate([
                'employee_number' => 'required|integer|unique:' . Employee::class,
                'department_id' => 'required|string|exists:entities,id',
                'station_id' => 'required|string|exists:entities,id',
                'route_id' => 'required|string|exists:entities,id',
                'residential_area_id' => 'required|string|exists:residential_areas,id',
                'is_leadership' => 'required|boolean'
            ]);

            // Create the employee
            $employee = $this->create_emplyee(
                $request->input('employee_number'),
                $request->input('department_id'),
                $request->input('station_id'),
                $request->input('route_id'),
                $request->input('residential_area_id'),
                $request->input('is_leadership')
            );

            return response()->json([
                'employee_data' => $employee,
                'message' => __('Successfully adding new employee')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are problem in server side try another time')
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Get the employee by ID and check if it exists
        try {

            $request->validate([
                'id' => 'required|string|exists:employees,id'
            ]);

            $id = $request->input('id');

            $employee = getAndCheckModelById(Employee::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return new EmployeeResource($employee);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'employee_id' => 'required|string|exists:employees,id',
                'employee_number' => 'required|integer|unique:' . Employee::class,
                'department_id' => 'required|string|exists:entities,id',
                'station_id' => 'required|string|exists:entities,id',
                'route_id' => 'required|string|exists:entities,id',
                'residential_area_id' => 'required|string|exists:residential_areas,id',
                'is_leadership' => 'required|boolean'
            ]);

            $employee = getAndCheckModelById(Employee::class, $request->input('employee_id'));

            // Create the employee
            $employee->update([
                'employee_number' => $request->input('employee_number'),
                'department_id' => $request->input('department_id'),
                'station_id' => $request->input('station_id'),
                'route_id' => $request->input('route_id'),
                'residential_area_id' => $request->input('residential_area_id'),
                'is_leadership' => $request->input('is_leadership')
            ]);

            return response()->json([
                'employee_data' => $employee,
                'message' => __('Successfully adding new employee')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('There are problem in server side try another time')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // Get the employee by ID and check if it exists
        try {

            $request->validate([
                'id' => 'required|string|exists:employees,id'
            ]);

            $id = $request->input('id');

            $employee = getAndCheckModelById(Employee::class, $id);
        } catch (NotFoundResourceException $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        // Delete the employee
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }

    /**
     * Export csv file with employees details
     */
    public function export_csv_employees_file()
    {
        try {
            // get the employees
            $employees = $this->get_employees();

            // define data array to store the employee data
            $data = [];

            // store every employee in data array
            foreach ($employees as $employee) {
                $data[] = [
                    "id" => $employee->id,
                    "number" => $employee->number,
                    "leadership" => $employee->leadership,
                    "residential_area_name" => $employee->residential_area_name,
                    "residential_area_location" => $employee->residential_area_location,
                    "department_name" => $employee->department_name,
                    "station_name" => $employee->station_name,
                    "route_name" => $employee->route_name
                ];
            }

            // define csv file
            $file = fopen('employees.csv', 'w');

            // store the data in the csv file
            fputcsv($file, array_keys($data[0]));
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            // close the file after saving the data in
            fclose($file);

            // return response with the data
            return response()->download('employees.csv')->deleteFileAfterSend(true);
        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there are error in server side try another time')
            ]);
        }
    }

    /**
     * import csv file with employees details to store in database
     */
    public function import_csv_employees_file(Request $request)
    {

        try {

            $request->validate([
                'file' => 'required|file|mimes:csv,txt,xlsx|max:10048'
            ], [
                'file.required' => 'Please choose a file.',
                'file.file' => 'The uploaded file is not valid.',
                'file.mimes' => 'The file must be in CSV,XLSX or TXT file.',
                'file.max' => 'The file size must not exceed 10MB.',
            ]);

            $file = $request->file('file');

            $data = array_map('str_getcsv', file($file));

            $counter = 0;
            foreach ($data as $row) {
                // Skip the first row
                if ($counter == 0) {
                    $counter++;
                    continue;
                }

                $this->create_emplyee(
                    employee_number: $row[0],
                    department_id: getIdByName(Entity::class, $row[4]),
                    station_id: getIdByName(Entity::class, $row[5]),
                    route_id: getIdByName(Entity::class, $row[6]),
                    residential_area_id: getIdByName(Residential_area::class, $row[2]),
                    is_leadership: $row[1] == '1' ? true : false
                );

            }

            // return response with the data
            return response()->json([
                'message' => __('Successfully adding data to database')
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'error' => __($e->getMessage()),
                'message' => __('there are error in server side try another time')
            ]);
        }

    }
}

