<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'employees' table
        DB::table('employees')->insert([
            [
                'id' => '1exlla6d-7b19-4fa9-a77f-2a76172f5b58',
                'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
                'route_id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'department_id' => '1n05a6d-7b19-4fa9-a77f-2a76172f5b58',
                'station_id' => '3a97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'residential_area_id' => 'asdasdasdasdasdasdasd',
                'employee_number' => 1,
                'is_leadership' => true,
                'slug' => 'employee-1',
                'created_at' => now(),
            ],
            [
                'id' => '2exlla6d-7b19-4fa9-a77f-2a76172f5b58',
                'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
                'route_id' => '1ara6d-7b19-4fa9-a77f-2a76172f5b58',
                'department_id' => '1n05a6d-7b19-4fa9-a77f-2a76172f5b58',
                'station_id' => '3a97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'residential_area_id' => 'ssssssseeeeeewwwwqqqq',
                'employee_number' => 2,
                'is_leadership' => false,
                'slug' => 'employee-2',
                'created_at' => now(),
            ],
        ]);
    }
}
