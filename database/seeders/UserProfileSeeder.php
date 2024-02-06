<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert sample data into the 'user_profiles' table
        DB::table('user_profiles')->insert([
            'id' => "21c97a6d-7b19-4fa9-a77f-2a76172f5b59",
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Replace with an existing user's ID
            'name' => 'First Tenant Company',
            'contact_person' => 'First Contact Person',
            'location' => 'First Tenant Company Location',
            'phone_number' => '+90 5684559877',
            'created_at' => now(),
        ]);

        DB::table('user_profiles')->insert([
            'id' => "22c97a6d-7b19-4fa9-a77f-2a76172f5b59",
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Replace with an existing user's ID
            'name' => 'First Portal Manager',
            'contact_person' => 'Second Contact Person',
            'location' => 'First Portal Manager Location',
            'phone_number' => '+90 1234567899',
            'created_at' => now(),
        ]);

        DB::table('user_profiles')->insert([
            'id' => "23c97a6d-7b19-4fa9-a77f-2a76172f5b59",
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Replace with an existing user's ID
            'name' => 'First Industrial Area',
            'contact_person' => 'Third Contact Person',
            'location' => 'First Industrial Area Location',
            'phone_number' => '+90 500000000',
            'created_at' => now(),
        ]);


        DB::table('user_profiles')->insert([
            'id' => "24c97a6d-7b19-4fa9-a77f-2a76172f5b59",
            'user_id' => '15c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Replace with an existing user's ID
            'name' => 'Second Industrial Area',
            'contact_person' => 'Forth Contact Person',
            'location' => 'Second Industrial Area',
            'phone_number' => '+90 004000000',
            'created_at' => now(),
        ]);


        DB::table('user_profiles')->insert([
            'id' => "25c97a6d-7b19-4fa9-a77f-2a76172f5b59",
            'user_id' => '16c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Replace with an existing user's ID
            'name' => 'Infrastructure Provider',
            'contact_person' => 'Infrastructure Provider Contact Person',
            'location' => 'Infrastructure Provider Location',
            'phone_number' => '+90 000003000',
            'created_at' => now(),
        ]);

        DB::table('user_profiles')->insert([
            'id' => "26c97a6d-7b19-4fa9-a77f-2a76172f5b59",
            'user_id' => '17c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Replace with an existing user's ID
            'name' => 'Government Representative',
            'contact_person' => 'Government Representative Contact Person',
            'location' => 'Government Representative Location',
            'phone_number' => '+92 000020000',
            'created_at' => now(),
        ]);

    }
}
