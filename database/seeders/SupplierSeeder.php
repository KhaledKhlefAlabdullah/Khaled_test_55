<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'suppliers' table
        DB::table('suppliers')->insert([
            [
                'id' => '001ra6d-a77f-4fa9-a77f-2a76172f5b58',
                'route_id' => '1ara6d-7b19-4fa9-a77f-2a76172f5b58',
                'material_id' => '2a97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
                'public_id' => 'SC01',
                'location' => 'Supplier Location 3',
                'contact_info' => 'Supplier Contact Info 3',
                'slug' => 'supplier-3',
                'is_available' => false,
                'created_at' => now(),
            ],
            [
                'id' => '002ra6d-a77f-4fa9-a77f-2a76172f5b58',
                'route_id' => '1ara6d-7b19-4fa9-a77f-2a76172f5b58',
                'material_id' => '8a87a6d-7b19-4fa9-a77f-2a76172f5b58',
                'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
                'public_id' => 'SUP02',
                'location' => 'Supplier Location 4',
                'contact_info' => 'Supplier Contact Info 4',
                'slug' => 'supplier-4',
                'is_available' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
