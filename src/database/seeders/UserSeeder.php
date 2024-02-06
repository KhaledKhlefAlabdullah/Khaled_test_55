<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert sample data into the 'users' table
        // First
        DB::table('users')->insert([
            'id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'email' => 'porta.manager.first@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'stakeholder_type' => 'Portal_manager',
            'is_active' => true, // or false depending on your requirement
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        // Second
        DB::table('users')->insert([
            'id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'email' => 'tenant.company.first@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'stakeholder_type' => 'Tenant_company',
            'is_active' => true, // or false depending on your requirement
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
            'email' => 'tenant.company.second@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'stakeholder_type' => 'Tenant_company',
            'is_active' => true, // or false depending on your requirement
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        // Third
        DB::table('users')->insert([
            'id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'industrial_area_id' => '45c97a6d-7b19-4fa9-a77f-2a76172f5b97',
            'email' => 'iar.first@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'stakeholder_type' => 'Industrial_area_representative',
            'is_active' => true, // or false depending on your requirement
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        // Forth
        DB::table('users')->insert([
            'id' => '15c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'industrial_area_id' => '46c97a6d-7b19-4fa9-a77f-2a76172f5b97',
            'email' => 'iar.second@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'stakeholder_type' => 'Industrial_area_representative',
            'is_active' => true, // or false depending on your requirement
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        // Fifth
        DB::table('users')->insert([
            'id' => '16c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'email' => 'infrastructure.provider.first@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'stakeholder_type' => 'Infrastructure_provider',
            'is_active' => true, // or false depending on your requirement
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

        // Sixth
        DB::table('users')->insert([
            'id' => '17c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'email' => 'government.representative.first@example.com',
            'email_verified_at' => now(),
            'password' => password_hash('12345', PASSWORD_DEFAULT),
            'stakeholder_type' => 'Government_representative',
            'is_active' => true, // or false depending on your requirement
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ]);

    }
}
