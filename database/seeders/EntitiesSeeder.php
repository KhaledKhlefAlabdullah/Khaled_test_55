<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First seed
        DB::table('entities')->insert([
            'id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '018e8400-e29b-41d4-a716-446655440000', // route
            'name' => 'Route 1',
            'public_id' => 'R01',
            'slug' => 'route-1',
            'phone_number' => '123-456-7890',
            'location' => 'Location A',
            'from' => 'Location AA',
            'to' => 'Location BB',
            'usage' => 'Employees transportation',
            'is_available' => true,
            'note' => 'This entity is available for rent.',
            'description' => 'Entity A is a versatile space suitable for various purposes.',
            'created_at' => now(),

        ]);

        DB::table('entities')->insert([
            'id' => '1ara6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '018e8400-e29b-41d4-a716-446655440000', // route
            'name' => 'Route 5',
            'public_id' => 'R02',
            'slug' => 'route-5',
            'phone_number' => '123-456-7890',
            'location' => 'Location F',
            'from' => 'Location FF',
            'to' => 'Location FFFF',
            'usage' => 'Supplies',
            'is_available' => true,
            'note' => 'This entity is available for rent.',
            'description' => 'Entity A is a versatile space suitable for various purposes.',
            'created_at' => now(),

        ]);

        DB::table('entities')->insert([
            'id' => '1araf3-7d17-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '005e8400-e29b-4154-a716-446655445600', // route
            'name' => 'Production Site 1',
            'public_id' => 'PS 1',
            'slug' => 'site 1',
            'location' => 'Location F',
            'is_available' => true,
            'created_at' => now(),
        ]);

        DB::table('entities')->insert([
            'id' => '1ard6q-7b19-4fa9-p77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '005e8400-e29b-4154-a716-446655445600', // route
            'name' => 'Production Site 2',
            'public_id' => 'PS 2',
            'slug' => 'site 2',
            'location' => 'Location 5TY',
            'is_available' => true,
            'created_at' => now(),
        ]);

        // Second seed
        DB::table('entities')->insert([
            'id' => '2a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '019e8400-e29b-41d4-a716-446655440000', // material
            'name' => 'Diamond',
            'public_id' => 'M01',
            'slug' => 'diamond',
            'created_at' => now(),
        ]);

        // Second seed
        DB::table('entities')->insert([
            'id' => '8a87a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '019e8400-e29b-41d4-a716-446655440000', // material
            'name' => 'Oil',
            'public_id' => 'M02',
            'slug' => 'oil',
            'created_at' => now(),
        ]);

        DB::table('entities')->insert([
            'id' => 'vv97a6d-7b19-4fa9-a7vf-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '048e8400-e29b-41d4-a716-446655440000', // waste disposal site
            'name' => 'Waste disposal site',
            'public_id' => 'WDS01',
            'slug' => 'waste-disposal-site',
            'created_at' => now(),
        ]);

        DB::table('entities')->insert([
            'id' => '3a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '020e8400-e29b-41d4-a716-446655440000', // station
            'name' => 'First Station',
            'public_id' => 'S01',
            'slug' => 'station',
            'location' => 'Location Station',
            'created_at' => now(),
        ]);

        // Second seed
        DB::table('entities')->insert([
            'id' => '8a00a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '017e8400-e29b-41d4-a716-446655440000', // product
            'name' => 'Salty',
            'public_id' => 'P01',
            'slug' => 'salty',
            'created_at' => now(),
        ]);

        // Second seed
        DB::table('entities')->insert([
            'id' => '8a01a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '017e8400-e29b-41d4-a716-446655440000', // product
            'name' => 'Apple',
            'public_id' => 'P02',
            'slug' => 'apple',
            'created_at' => now(),
        ]);

        DB::table('entities')->insert([
            'id' => '9a05a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '037e8400-e29b-41d4-a716-446655440000', // customer
            'name' => 'Ali',
            'public_id' => 'SUP01',
            'slug' => 'ali-55',
            'created_at' => now(),
        ]);

        DB::table('entities')->insert([
            'id' => '9aRC46d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '037e8400-e29b-41d4-a716-446655440000', // customer
            'name' => 'Muhannad',
            'public_id' => 'SUP02',
            'slug' => 'ali-55',
            'created_at' => now(),
        ]);

        DB::table('entities')->insert([
            'id' => '1n05a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '038e8400-e29b-41d4-a716-446655440000', // department
            'name' => 'IT',
            'public_id' => "IT01",
            'slug' => 'it',
            'created_at' => now(),
        ]);

        DB::table('entities')->insert([
            'id' => '1n05A64-8n19-7fG9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '048e8400-e29b-41d4-a716-446655440000',
            'name' => 'Wastes Disposal site 2',
            'public_id' => "WA 01",
            'slug' => 'wast',
            'location' => 'location-disposal-A',
            'created_at' => now(),
        ]);

    }
}
