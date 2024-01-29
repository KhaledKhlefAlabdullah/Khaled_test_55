<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'shipments' table
        DB::table('shipments')->insert([
            [
                'id' => '1r00a6d-5236-4fa9-5236-2a76172f5b58',
                'route_id' => '1ara6d-7b19-4fa9-a77f-2a76172f5b58',
                'product_id' => '8a00a6d-7b19-4fa9-a77f-2a76172f5b58', // entity
                'customer_id' => '9a05a6d-7b19-4fa9-a77f-2a76172f5b58',
                'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
                'public_id' => 'SL01',
                'name' => 'Shipment Name 1',
                'location' => 'Shipment Location 1',
                'contact_info' => 'Shipment Contact Info 1',
                'created_at' => now(),
            ],
            [
                'id' => '1r01a6d-5236-4fa9-5236-2a76172f5b58',
                'route_id' => '1ara6d-7b19-4fa9-a77f-2a76172f5b58',
                'product_id' => '8a01a6d-7b19-4fa9-a77f-2a76172f5b58',
                'customer_id' => '9a05a6d-7b19-4fa9-a77f-2a76172f5b58',
                'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
                'public_id' => 'SL02',
                'name' => 'Shipment Name 2',
                'location' => 'Shipment Location 2',
                'contact_info' => 'Shipment Contact Info 2',
                'created_at' => now(),
            ],
        ]);
    }
}
