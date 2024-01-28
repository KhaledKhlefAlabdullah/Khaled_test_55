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
            'type' => 'Post',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '32c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'News',
            'type' => 'News',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '33c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'File',
            'type' => 'File',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Notification',
            'type' => 'Notification',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '11197a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Report',
            'type' => 'Notification',
            'parent_id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '23237a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Whether',
            'type' => 'Notification',
            'parent_id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '35c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Report',
            'type' => 'Report',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '36c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Timeline Event',
            'type' => 'Timeline_event',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '37c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Route',
            'type' => 'Entity',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '37r97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'About Page',
            'type' => 'Page',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '78c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Contact Us Page',
            'type' => 'Page',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '00c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Products',
            'type' => 'Entity',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '01c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Materials',
            'type' => 'Entity',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '02c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Stations',
            'type' => 'Entity',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '03597a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Suppliers',
            'type' => 'Entity',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '05597a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Waste disposal site',
            'type' => 'Entity',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '06597a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Routes',
            'type' => 'Entity',
            'created_at' => now(),
        ]);
    }
}
