<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WasteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wastes')->insert([
            'id' => 'rr00a6d-7b19-4fa9-a77f-2a76172f5b77',
            'route_id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',// Entity
            'waste_disposal_location_id' => 'vv97a6d-7b19-4fa9-a7vf-2a76172f5b58', // Entity
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'waste_name' => 'Sample Waste 1',
            'location' => 'Sample Location 1',
            'contact_info' => 'Sample Contact Info 1',
            'created_at' => now(),
        ]);

        DB::table('wastes')->insert([
            'id' => 'rr11a6d-7b19-4fa9-a77f-2a76172f5b77',
            'route_id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'waste_disposal_location_id' => 'vv97a6d-7b19-4fa9-a7vf-2a76172f5b58',
            'stakeholder_id' => '4r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'waste_name' => 'Sample Waste 2',
            'location' => 'Sample Location 2',
            'contact_info' => 'Sample Contact Info 2',
            'created_at' => now(),
        ]);
    }
}
