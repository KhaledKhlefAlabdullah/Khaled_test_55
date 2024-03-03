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
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Portal manager
            'page_id' => '6a97a6d-7b19-4fa9-a77f-2a76172f5b58', // General News Page
            'category_id' => '040e8400-e29b-41d4-a716-446655440000', // News Category
            'title' => 'General News',
            'body' => 'I am body for post',
            'media_url' => 'assets/images/temp.jpg',
            'media_type' => 'file',
            'is_general_news' => true,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '0009776d-7b19-55a9-k77f-2a76173f5822',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Portal manager
            'page_id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58', // About us Page
            'category_id' => '004e8400-e29b-41d4-a716-446655440000', // About Category
            'title' => 'Our Vision',
            'body' => 'I am body for our vision',
            'media_url' => null,
            'media_type' => null,
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '0005796g-7B19-55a9-k77f-2a76173f5822',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Portal manager
            'page_id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'category_id' => '004e8400-e29b-41d4-a716-446655440000',
            'title' => 'Our Approach',
            'body' => 'I am body for our approach',
            'media_url' => null,
            'media_type' => null,
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '0005796g-7B6c-8J39-k77f-2a76173f5822',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // Portal manager
            'page_id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58', // About us Page
            'category_id' => '004e8400-e29b-41d4-a716-446655440000', // About Category
            'title' => 'Our Process',
            'body' => 'I am body for our process',
            'media_url' => null,
            'media_type' => null,
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '109776d-7b19-55a9-a77f-2a76172f5222',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // IAR 1
            'page_id' => '5a97a6d-7b19-4fa9-a77f-2a76172f5b58', // News Page
            'category_id' => '040e8400-e29b-41d4-a716-446655440000', //  News Category
            'title' => 'General News',
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
            'body' => 'I am body for post',
            'is_priority' => false,
            'priority_count' => '4',
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '1009776d-7b19-55a9-a77f-2a76172f5322',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // IAR 1
            'page_id' => '4a97a6d-7b19-4fa9-a77f-2a76172f5b58', // News Page
            'category_id' => '003e8400-e29b-41d4-a716-446655440000',
            'title' => 'article 1',
            'body' => 'I am body for post',
            'is_priority' => false,
            'priority_count' => '4',
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);

        DB::table('posts')->insert([
            'id' => '1009776d-7b19-55a9-a77f-2a76172G5322',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // IAR 1
            'page_id' => '4a97a6d-7b19-4fa9-a77f-2a76172f5b58', 
            'category_id' => '003e8400-e29b-41d4-a716-446655440000',
            'title' => 'article 2',
            'body' => 'I am body for post',
            'is_priority' => false,
            'priority_count' => '4',
            'is_general_news' => false,
            'is_publish' => false,
            'created_at' => now(),
        ]);
    }
}
