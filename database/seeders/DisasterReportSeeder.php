<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisasterReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'disaster_reports' table
        DB::table('disaster_reports')->insert([

            'id' => '11io7a6d-a77f-4fa9-a77f-2a76172f5b58',
            'natural_disaster_id' => '115576d-5238-4fa9-a77f-2a76172f5b22',
            'shipment_id' => '1r00a6d-5236-4fa9-5236-2a76172f5b58',
            'is_safe' => true,
            'created_at' => now(),
        ]);
        DB::table('disaster_reports')->insert([
            'id' => '12io7a6d-a77f-4fa9-a77f-2a76172f5b58',
            'natural_disaster_id' => '115576d-5238-4fa9-a77f-2a76172f5b22',
            'employee_id' => '1exlla6d-7b19-4fa9-a77f-2a76172f5b58',
            'is_safe' => false,
            'created_at' => now(),
        ]);

        DB::table('disaster_reports')->insert([
            'id' => '13io7a6d-a77f-4fa9-a77f-2a76172f5b58',
            'natural_disaster_id' => '115576d-5238-4fa9-a77f-2a76172f5b22',
            'entity_id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'is_safe' => true,
            'impact_date' => '2024-03-01',
            'start_date' => '2024-03-02',
            'stop_date' => '2024-03-15',
            'created_at' => now(),
        ]);
    }
}
