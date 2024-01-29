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
            'type' => 'post',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '32c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'News',
            'type' => 'news',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '44c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'General News',
            'type' => 'general_news',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '33c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'File',
            'type' => 'file',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Notification',
            'type' => 'notification',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '11197a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Report',
            'type' => 'report',
            'parent_id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '23237a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Whether',
            'type' => 'whether',
            'parent_id' => '34c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '35c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'waste disposal site',
            'type' => 'waste_disposal_site',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '36c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Timeline Event',
            'type' => 'timeline_event',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '37c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Route',
            'type' => 'route',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '37r97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'About Page',
            'type' => 'about',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '78c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Contact Us Page',
            'type' => 'contact_us',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '00c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Products',
            'type' => 'products',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '01c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Materials',
            'type' => 'materials',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '02c97a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Stations',
            'type' => 'stations',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '03897a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Customer ',
            'type' => 'customer',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '04877a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Water',
            'type' => 'services',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '04899a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Energy',
            'type' => 'services',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '0oo99a6d-7b19-4fa9-a77f-2a76172f5b22',
            'name' => 'Department',
            'type' => 'department',
            'created_at' => now(),
        ]);
    }
}
