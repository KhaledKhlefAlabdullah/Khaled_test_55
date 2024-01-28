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
            'category_id' => '37c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Route 1',
            'public_id' => 22,
            'slug' => 'route-1',
            'phone_number' => '123-456-7890',
            'location' => 'Location A',
            'from' => 'Location AA',
            'to' => 'Location BB',
            'usage' => 'For Employee',
            'is_available' => true,
            'note' => 'This entity is available for rent.',
            'description' => 'Entity A is a versatile space suitable for various purposes.',
            'created_at' => now()

        ]);

        // Second seed
        DB::table('entities')->insert([
            'id' => '2a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '01c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Diamond',
            'public_id' => 33,
            'slug' => 'diamond',
            'created_at' => now()
        ]);

        DB::table('entities')->insert([
            'id' => 'vv97a6d-7b19-4fa9-a7vf-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '35c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Waste disposal site',
            'public_id' => 77,
            'slug' => 'waste-disposal-site',
            'created_at' => now()
        ]);

        DB::table('entities')->insert([
            'id' => '3a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'category_id' => '03597a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'First Station',
            'public_id' => 88,
            'slug' => 'station',
            'location' => 'Location Station',
            'created_at' => now()
        ]);
    }
}
