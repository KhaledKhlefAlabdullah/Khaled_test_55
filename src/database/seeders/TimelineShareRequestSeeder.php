<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimelineShareRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Timeline Shares Request 1
        DB::table('timeline_shares_requests')->insert([
            'id' => '550e8400-e29b-41d4-a716-446655440000',
            'timeline_id' => 'abcdfs01-7b19-4fa9-a77f-2a76172f5b99',
            'send_stakeholder_id' => '2r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'receive_stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'status' => 'pending',
            'send_date' => '2024-01-01',
            'end_date' => '2024-01-10',
            'created_at' => now(),
        ]);

        // Timeline Shares Request 2
        DB::table('timeline_shares_requests')->insert([
            'id' => '660e8400-e29b-41d4-a716-446655440000',
            'timeline_id' => 'abcdfs02-7b19-4fa9-a77f-2a76172f5b99',
            'send_stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'receive_stakeholder_id' => '2r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'status' => 'pending',
            'send_date' => '2024-02-01',
            'end_date' => '2024-02-10',
            'created_at' => now(),
        ]);
    }
}
