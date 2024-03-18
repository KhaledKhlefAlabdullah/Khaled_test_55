<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonitoringPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'monitoring_points' table
        DB::table('monitoring_points')->insert([
            [
                'id' => '119976d-5238-4fa9-a77f-2a76172f5b22',
                'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // portal manager
                'industrial_area_id' => '45c97a6d-7b19-4fa9-a77f-2a76172f5b97' ,
                'name' => 'Monitoring Point 1',
                'location' => 'Coordinates: [latitude, longitude]',
                'point_type' => 'normal',
                'api_link' => 'http://example.com/api/monitoring-point-1',
                'is_custom' => false,
                'water_level' => 3.5,
                'risk_indicators' => 'Low',
                'discharge' => 'Moderate',
                'source' => 'River A',
                'created_at' => now(),
            ],
            [
                'id' => '229976d-5238-4fa9-a77f-2a76172f5b22',
                'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // tenant company
                'industrial_area_id' => '45c97a6d-7b19-4fa9-a77f-2a76172f5b97' ,
                'name' => 'Monitoring Point 2',
                'location' => 'Coordinates: [latitude, longitude]',
                'point_type' => 'high',
                'api_link' => 'http://example.com/api/monitoring-point-2',
                'is_custom' => true,
                'water_level' => 7.2,
                'risk_indicators' => 'High',
                'discharge' => 'High',
                'source' => 'Lake B',
                'created_at' => now(),
            ],
        ]);
    }
}
