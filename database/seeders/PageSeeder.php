<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First seed
        DB::table('pages')->insert([
            'id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'About Page',
            'type' => 'About',
            'description' => 'Join us for an exciting event!',
            'phone_number' => '123-456-7890',
            'location' => 'Venue A',
            'created_at' => now(),

        ]);

        // Second seed
        DB::table('pages')->insert([
            'id' => '2a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'Contact Us Page',
            'type' => 'Contact-Us',
            'description' => 'Another exciting event!',
            'phone_number' => '987-654-3210',
            'location' => 'Venue B',
            'start_time' => '2024-02-15 12:00:00',
            'end_time' => '2024-02-15 16:00:00',
            'created_at' => now(),

        ]);

        // Third seed
        DB::table('pages')->insert([
            'id' => '3a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'Webinar Page 1',
            'type' => 'Webinar',
            'description' => 'Learn from industry experts!',
            'created_at' => now(),

        ]);

        // Fourth seed
        DB::table('pages')->insert([
            'id' => '4a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'Article Page',
            'type' => 'Article',
            'description' => 'Exciting new products!',
            'location' => 'Venue C',
            'created_at' => now(),

        ]);

        // Fifth seed
        DB::table('pages')->insert([
            'id' => '5a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'News Page',
            'type' => 'News',
            'location' => 'Venue D',
            'created_at' => now(),
        ]);

        // Fifth seed
        DB::table('pages')->insert([
            'id' => '6a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Portal manager
            'title' => 'General News Page',
            'type' => 'General News',
            'location' => 'Venue D',
            'created_at' => now(),
        ]);

    }
}
