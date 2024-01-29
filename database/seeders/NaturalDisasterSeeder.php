<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NaturalDisasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'natural_disasters' table
        DB::table('natural_disasters')->insert([
            [
                'id' => '115576d-5238-4fa9-a77f-2a76172f5b22',
                'name' => 'Earthquake',
                'disaster_type' => 'Seismic',
                'disaster_date' => '2024-01-29',
                'description' => 'Severe earthquake with high magnitude.',
                'location' => 'Coordinates: [latitude, longitude]',
                'created_at' => now(),
            ],
            [
                'id' => '225576d-5238-4fa9-a77f-2a76172f5b22',
                'name' => 'Hurricane',
                'disaster_type' => 'Meteorological',
                'disaster_date' => '2024-02-15',
                'description' => 'Powerful hurricane with strong winds and heavy rainfall.',
                'location' => 'Coordinates: [latitude, longitude]',
                'created_at' => now(),
            ],
            [
                'id' => '335576d-5238-4fa9-a77f-2a76172f5b22',
                'name' => 'Flood',
                'disaster_type' => 'Hydrological',
                'disaster_date' => '2024-03-01',
                'description' => 'Widespread flooding due to heavy rain or river overflow.',
                'location' => 'Coordinates: [latitude, longitude]',
                'created_at' => now(),
            ],
            [
                'id' => '445576d-5238-4fa9-a77f-2a76172f5b22',
                'name' => 'Wildfire',
                'disaster_type' => 'Wildfire',
                'disaster_date' => '2024-04-15',
                'description' => 'Uncontrolled fire spreading through forests or grasslands.',
                'location' => 'Coordinates: [latitude, longitude]',
                'created_at' => now(),
            ],
        ]);
    }
}
