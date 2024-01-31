<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StakeholderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First stakeholder record
        // Tenant company
        DB::table('stakeholders')->insert([
            'id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'industrial_area_id' => '45c97a6d-7b19-4fa9-a77f-2a76172f5b97',
            'tenant_company_state' => 'operating',
            'company_representative_name' => 'John Smith',
            'job_title' => 'Manager',
            'created_at' => now(),
        ]);

        // Second stakeholder record
        // Tenant company
        DB::table('stakeholders')->insert([
            'id' => '2r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'user_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
            'industrial_area_id' => '45c97a6d-7b19-4fa9-a77f-2a76172f5b97',
            'tenant_company_state' => 'evacuating',
            'company_representative_name' => 'Jane Doe',
            'job_title' => 'Director',
            'created_at' => now(),
        ]);

        // infrastructure provider
        DB::table('stakeholders')->insert([
            'id' => '4r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'user_id' => '16c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'industrial_area_id' => '45c97a6d-7b19-4fa9-a77f-2a76172f5b97',
            'representative_government_agency' => 'Ministry of Environment',
            'tenant_company_state' => 'evacuated',
            'company_representative_name' => 'Jane Doe',
            'job_title' => 'Director',
            'infrastructures_state' => 'partially',
            'infrastructure_type' => 'Water Treatment Plant',
            'created_at' => now(),

        ]);

        DB::table('stakeholders')->insert([
            'id' => '5r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'user_id' => '17c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'industrial_area_id' => '45c97a6d-7b19-4fa9-a77f-2a76172f5b97',
            'representative_government_agency' => 'Ministry of Environment',
            'tenant_company_state' => 'trapped',
            'company_representative_name' => 'Jane Doe',
            'job_title' => 'Director',
            'infrastructures_state' => 'interrupted',
            'infrastructure_type' => 'Water Treatment Plant',
            'created_at' => now(),

        ]);

    }
}
