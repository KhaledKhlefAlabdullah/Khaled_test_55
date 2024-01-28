<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipatingEntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('participating_entities')->insert([
            'id' => "1dd97a6d-7b19-4fa9-a78f-2a76172f5b58",
            'user_id' => "13c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "First Title",
            'media_url' => "images/participating1.jpg",
            'media_type' => "image",
            'created_at' => now()
        ]);

        DB::table('participating_entities')->insert([
            'id' => "2dd97a6d-7b19-4fa9-a78f-2a76172f5b58",
            'user_id' => "13c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "Second Title",
            'media_url' => "video/temp.mp4",
            'media_type' => "video",
            'created_at' => now()

        ]);

        DB::table('participating_entities')->insert([
            'id' => "3dd97a6d-7b19-4fa9-a78f-2a76172f5b58",
            'user_id' => "13c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "Third Title",
            'media_url' => "https://google.com",
            'media_type' => "website_URL",
            'created_at' => now()

        ]);

        DB::table('participating_entities')->insert([
            'id' => "4dd97a6d-7b19-4fa9-a78f-2a76172f5b58",
            'user_id' => "13c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "Forth Title",
            'media_url' => "file/temp.pdf",
            'media_type' => "file",
            'created_at' => now()
        ]);
    }
}
