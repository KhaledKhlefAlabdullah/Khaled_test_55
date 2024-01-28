<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dams')->insert([
            'id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'name' => 'Dam 1',
            'location' => 'Location 1',
            'water_level' => 25.5,
            'discharge' => '1000 cubic meters per second',
            'source' => 'River A',
            'created_at' => now()
        ]);

        DB::table('dams')->insert([
            'id' => '2a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'name' => 'Dam 2',
            'location' => 'Location 2',
            'water_level' => 32.0,
            'discharge' => '1200 cubic meters per second',
            'source' => 'River B',
            'created_at' => now()
        ]);

    }
}
