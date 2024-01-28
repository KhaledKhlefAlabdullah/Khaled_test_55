<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('timelines')->insert([
            'id' => "abcdfs01-7b19-4fa9-a77f-2a76172f5b99",
            'stakeholder_id' => "2r97a6d-5238-4fa9-a77f-2a76172f5b58", // Tenant company
            'created_at' => now(),
        ]);

        DB::table('timelines')->insert([
            'id' => "abcdfs02-7b19-4fa9-a77f-2a76172f5b99",
            'stakeholder_id' => "1r97a6d-5236-4fa9-a77f-2a76172f5b58", // Tenant company
            'created_at' => now(),
        ]);
    }
}
