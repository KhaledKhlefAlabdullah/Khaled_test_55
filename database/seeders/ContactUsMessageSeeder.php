<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactUsMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First seed
        DB::table('contact_us_messages')->insert([
            'id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'subject' => 'hello',
            'message' => 'Hello, I have a question about your services.',
            'is_read' => true,
            'created_at' => now()

        ]);

// Second seed
        DB::table('contact_us_messages')->insert([
            'id' => '2a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
            'subject' => 'hello',
            'message' => 'I would like more information about your products.',
            'is_read' => false,
            'created_at' => now()

        ]);

// Third seed
        DB::table('contact_us_messages')->insert([
            'id' => '3a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'subject' => 'hello',
            'message' => 'I am interested in collaborating with your company.',
            'is_read' => true,
            'created_at' => now()

        ]);

// Fourth seed
        DB::table('contact_us_messages')->insert([
            'id' => '4a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '15c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'subject' => 'hello',
            'message' => 'Could you provide pricing details for your services?',
            'is_read' => false,
            'created_at' => now()

        ]);

// Fifth seed
        DB::table('contact_us_messages')->insert([
            'id' => '5a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '16c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'subject' => 'hello',
            'message' => 'I encountered an issue with your website. Can you assist?',
            'is_read' => false,
            'created_at' => now()

        ]);

    }
}
