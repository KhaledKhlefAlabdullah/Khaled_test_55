<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First file seed
        DB::table('files')->insert([
            'id' => '1a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'category_id' => '003e8400-e29b-41d4-a716-446655440000',
            'file_type' => 'Educational',
            'title' => 'Introduction to Portal',
            'description' => 'A beginner\'s guide to Portal.',
            'version' => '1.0',
            'media_url' => 'https://example.com/Portal-intro.pdf',
            'media_type' => 'file',
            'update_frequency' => 'monthly',
            'created_at' => now(),

        ]);

// Second file seed
        DB::table('files')->insert([
            'id' => '2a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'category_id' => '003e8400-e29b-41d4-a716-446655440000',
            'file_type' => 'Educational',
            'title' => 'User Educational for Product X',
            'description' => 'Step-by-step guide for using Product X.',
            'version' => '2.5',
            'media_url' => 'https://example.com/product-x-manual.pdf',
            'media_type' => 'file',
            'update_frequency' => 'weekly',
            'created_at' => now(),

        ]);

// Third file seed
        DB::table('files')->insert([
            'id' => '3a97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'category_id' => '003e8400-e29b-41d4-a716-446655440000',
            'file_type' => 'Educational',
            'title' => 'Project Educational Y Blueprint',
            'description' => 'Architectural Educational for Project Y construction.',
            'version' => '3.0',
            'media_url' => 'https://example.com/project-y-blueprint.pdf',
            'media_type' => 'file',
            'update_frequency' => 'daily',
            'created_at' => now(),
        ]);

    }
}
