<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First registration request
        DB::table('registration_requests')->insert([
            'id' => '1b97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'name' => 'First Tenant Company',
            'representative_name' => 'John Doe',
            'email' => 'tenant.company.first@example.com',
            'password' => Hash::make('12345'),
            'location' => 'Location A',
            'phone_number' => '1234567890',
            'job_title' => 'CEO',
            'created_at' => now()

        ]);

        // Second registration request
        DB::table('registration_requests')->insert([
            'id' => '2b97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '15c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'name' => 'Second Tenant Company',
            'representative_name' => 'Ali Jane Doe',
            'email' => 'tenant.company.second@example.com',
            'password' => bcrypt('12345'),
            'location' => 'Location B',
            'phone_number' => '9876543210',
            'job_title' => 'CTO',
            'created_at' => now()

        ]);
    }
}
