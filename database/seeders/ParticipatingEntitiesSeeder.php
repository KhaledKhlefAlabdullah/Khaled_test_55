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
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "First Title",
            'logo_url' => "images/participating1.jpg",
            'link' => null,
            'created_at' => now()
        ]);

        DB::table('participating_entities')->insert([
            'id' => "2dd97a6d-7b19-4fa9-a78f-2a76172f5b58",
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "Second Title",
            'logo_url' => "video/temp.mp4",
            'link' => null,
            'created_at' => now()

        ]);

        DB::table('participating_entities')->insert([
            'id' => "3dd97a6d-7b19-4fa9-a78f-2a76172f5b58",
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "Third Title",
            'logo_url' => "https://google.com",
            'link' => null,
            'created_at' => now()

        ]);

        DB::table('participating_entities')->insert([
            'id' => "4dd97a6d-7b19-4fa9-a78f-2a76172f5b58",
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'title' => "Forth Title",
            'logo_url' => "file/temp.pdf",
            'link' => null,
            'created_at' => now()
        ]);
    }
}
