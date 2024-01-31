<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResidentialAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // Insert data into the residential_areas table

            DB::table('residential_areas')->insert(
                [
                    [
                        'id' => 'asdasdasdasdasdasdasd',
                        'name' => 'Area 1',
                        'location' => 'Location 1'
                    ],
                    [
                        'id' => 'ssssssseeeeeewwwwqqqq',
                        'name' => 'Area 2',
                        'location' => 'Location 2'
                    ]
                ]
            );


    }
}
