<?php

namespace Database\Seeders;

use App\Models\Timelines\TimelineEvent;
use Illuminate\Database\Seeder;

class TimelineEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Timeline Event 1
        TimelineEvent::create([
            'id' => '00000701-7b19-4fa9-a77f-2a76172f5b99',
            'timeline_id' => 'abcdfs01-7b19-4fa9-a77f-2a76172f5b99',
            'category_id' => '009e8400-e29b-41d4-a716-446655440TLE', // Timeline category
            'title' => 'Event Title 1',
            'start_date' => '2024-01-28 12:29:13',
            'end_date' => '2024-02-28 12:29:13',
            'description' => 'Event Description 1',
            'production_percentage' => 80.5,
            'is_active' => true,
            'created_at' => now()
        ]);

        // Timeline Event 2
        TimelineEvent::create([
            'id' => '00000702-7b19-4fa9-a77f-2a76172f5b99',
            'timeline_id' => 'abcdfs02-7b19-4fa9-a77f-2a76172f5b99',
            'category_id' => '009e8400-e29b-41d4-a716-446655440TLE', // Timeline category_id
            'title' => 'Event Title 2',
            'start_date' => '2024-02-08 12:29:01',
            'end_date' => '2024-02-15 12:15:13',
            'description' => 'Event Description 2',
            'production_percentage' => 90.2,
            'is_active' => true,
            'created_at' => now()
        ]);

        // Timeline Event 1
        TimelineEvent::create([
            'id' => '00000703-7b19-4fa9-a77f-2a76172f5b99',
            'timeline_id' => 'abcdfs01-7b19-4fa9-a77f-2a76172f5b99',
            'category_id' => '009e8400-e29b-41d4-a716-446655440TLE', // Timeline category
            'title' => 'Event Title 3',
            'start_date' => '2024-02-02 12:29:01',
            'end_date' => '2024-03-06 12:15:13',
            'description' => 'Event Description 3',
            'production_percentage' => 80.5,
            'is_active' => true,
            'created_at' => now()
        ]);

        // Timeline Event 2
        TimelineEvent::create([
            'id' => '00000704-7b19-4fa9-a77f-2a76172f5b99',
            'timeline_id' => 'abcdfs02-7b19-4fa9-a77f-2a76172f5b99',
            'category_id' => '009e8400-e29b-41d4-a716-446655440TLE', // Timeline category_id
            'title' => 'Event Title 4',
            'start_date' => '2024-02-16 12:29:01',
            'end_date' => '2024-02-17 12:15:13',
            'description' => 'Event Description 4',
            'production_percentage' => 90.2,
            'is_active' => true,
            'created_at' => now()
        ]);
    }
}
