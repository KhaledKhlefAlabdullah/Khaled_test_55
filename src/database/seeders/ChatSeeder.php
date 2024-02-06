<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chats')->insert([
            [
                'id' => '14ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'chat_name' => 'First and Second',
                'created_at' => now(),
            ],
            [
                'id' => '24ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'chat_name' => 'Third and Forth',
                'created_at' => now(),
            ],

        ]);

    }
}
