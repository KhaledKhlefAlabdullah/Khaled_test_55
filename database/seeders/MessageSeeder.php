<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed data for the 'messages' table
        DB::table('messages')->insert([
            [
                'id' => '14ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'sender_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'receiver_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
                'chat_id' => '14ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'message' => 'Hello, how are you?',
                'message_type' => 'text',
                'is_read' => true,
                'is_edit' => false,
                'is_starred' => true,
                'created_at' => now(),
            ],
            [
                'id' => '15ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'sender_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
                'receiver_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'chat_id' => '14ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'message' => 'Hi, I am good. How about you?',
                'message_type' => 'text',
                'is_read' => true,
                'is_edit' => false,
                'is_starred' => false,
                'created_at' => now(),
            ],
            [
                'id' => '16ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'sender_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'receiver_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
                'chat_id' => '14ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'message' => 'Check out this funny cat video!',
//                'media_url' => 'http://example.com/cat-video.mp4',
                'message_type' => 'video',
                'is_read' => true,
                'is_edit' => false,
                'is_starred' => false,
                'created_at' => now(),
            ],
            [
                'id' => '17ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'sender_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
                'receiver_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
                'chat_id' => '14ppa6d-a77f-4fa9-a77f-2a76172f5b58',
                'message' => 'Haha, that was hilarious!',
                'message_type' => 'text',
                'is_read' => false,
                'is_edit' => false,
                'is_starred' => true,
                'created_at' => now(),
            ],
        ]);
    }
}
