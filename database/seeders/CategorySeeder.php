<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'id' => '31c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Post',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '32c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'News',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '44c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'General News',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '005e8400-e29b-4154-a716-446655440000',
            'name' => 'Project Description',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-446655440000',
            'name' => 'File',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Notification',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '11197a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Report',
            'parent_id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '23237a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Whether',
            'parent_id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '35c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Waste Disposal Site',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '36c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Timeline Event',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '37c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Route',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '37r97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'About Page',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '78c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Contact Us Page',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '00c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Products',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '01c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Materials',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '02c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Stations',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '03897a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Customer ',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '04877a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Water',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '04899a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Energy',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '0oo99a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Department',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '037e8400-e29b-41d4-a716-446655440000',
            'name' => 'Customer',
            'created_at' => now(),
        ]);
    }
}
