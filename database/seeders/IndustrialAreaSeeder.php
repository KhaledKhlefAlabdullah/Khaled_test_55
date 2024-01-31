<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrialAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First
        DB::table('industrial_areas')->insert([
            'id' => "45c97a6d-7b19-4fa9-a77f-2a76172f5b97",
            'name' => 'First Industrial Area Name',
            'address' => 'First Industrial Area Address',
            'created_at' => now(),
        ]);


        // Second
        DB::table('industrial_areas')->insert([
            'id' => "46c97a6d-7b19-4fa9-a77f-2a76172f5b97",
            'name' => 'Second Industrial Area Name',
            'address' => 'Second Industrial Area Address',
            'created_at' => now(),
        ]);
    }
}
