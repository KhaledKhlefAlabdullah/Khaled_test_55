<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'services' table
        DB::table('services')->insert([
            [
                'id' => '4r97a6d-5238-4fa9-a77f-2a76172f5b22',
                'stakeholder_id' => '4r97a6d-5238-4fa9-a77f-2a76172f5b58',
                'category_id' => '046e8400-e29b-41d4-a716-446655440000', //  service
                'infrastructures_state' => 'available',
                'description' => 'Service Description 2',
                'start_date' => '2024-02-01',
                'end_date' => '2024-03-01',
                'created_at' => now(),
            ],
            [
                'id' => '7797a6d-5238-4fa9-a77f-2a76172f5b22',
                'stakeholder_id' => '4r97a6d-5238-4fa9-a77f-2a76172f5b58',
                'category_id' => '045e8400-e29b-41d4-a716-446655440000', //  service
                'infrastructures_state' => 'partially',
                'description' => 'Service Description 2',
                'start_date' => '2024-02-01',
                'end_date' => '2024-03-01',
                'created_at' => now(),
            ],
        ]);
    }
}
