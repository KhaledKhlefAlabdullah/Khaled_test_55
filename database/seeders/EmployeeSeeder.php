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
                'station_id' => 'your_station_id_1',
                'public_id' => 'EMP001',
                'is_leader_shop' => true,
                'slug' => 'employee-1',
                'phone_number' => '123-456-7890',
                'created_at' => now(),
            ],
            [
                'id' => '2exlla6d-7b19-4fa9-a77f-2a76172f5b58',
                'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
                'route_id' => '1ara6d-7b19-4fa9-a77f-2a76172f5b58',
                'department_id' => '1n05a6d-7b19-4fa9-a77f-2a76172f5b58',
                'station_id' => 'your_station_id_2',
                'public_id' => 'EMP002',
                'is_leader_shop' => false,
                'slug' => 'employee-2',
                'phone_number' => '987-654-3210',
                'created_at' => now(),
            ],
        ]);
    }
}
