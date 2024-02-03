<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            'id' => '0009776d-7b19-55a9-a77f-2a76172f5222',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Portal manager
            'page_id' => '6a97a6d-7b19-4fa9-a77f-2a76172f5b58', // General News Page
            'category_id' => '040e8400-e29b-41d4-a716-446655440000', // News Category
            'title' => 'General News',
            'slug' => 'general-news',
            'body' => 'I am body for post',
            'media_url' => 'assets/images/temp.jpg',
            'media_type' => 'file',
            'is_general_news' => true,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '109776d-7b19-55a9-a77f-2a76172f5222',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // IAR 1
            'page_id' => '5a97a6d-7b19-4fa9-a77f-2a76172f5b58', // News Page
            'category_id' => '040e8400-e29b-41d4-a716-446655440000', //  News Category
            'title' => 'General News',
            'slug' => 'general-news',
            'body' => 'I am body for post',
            'is_priority' => false,
            'priority_count' => '4',
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '1009776d-7b19-55a9-a77f-2a76172f5222',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // IAR 1
            'page_id' => '5a97a6d-7b19-4fa9-a77f-2a76172f5b58', // News Page
            'category_id' => '005e8400-e29b-4154-a716-446655440000',
            'title' => 'Project description',
            'slug' => 'description',
            'body' => 'I am body for post',
            'is_priority' => false,
            'priority_count' => '4',
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);
    }
}
