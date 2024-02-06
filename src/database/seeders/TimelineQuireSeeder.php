<?php

namespace Database\Seeders;

use App\Models\Timelines\TimelineQuire;
use Illuminate\Database\Seeder;

class TimelineQuireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Timeline Quire 1
        TimelineQuire::create([
            'id' => '55lm328-5238-4f11-a744-2a76172f5b77',
            'timeline_event_id' => '00000701-7b19-4fa9-a77f-2a76172f5b99',
            'stakeholder_id' => '2r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'inquiry' => 'Inquiry content 1',
            'created_at' => now(),
        ]);

        // Timeline Quire 2
        TimelineQuire::create([
            'id' => '56lm328-5238-4f11-a744-2a76172f5b77',
            'timeline_event_id' => '00000701-7b19-4fa9-a77f-2a76172f5b99',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'inquiry' => 'Inquiry content 2',
            'created_at' => now(),
        ]);


        // Timeline Quire 1
        TimelineQuire::create([
            'id' => '57lm328-5238-4f11-a744-2a76172f5b77',
            'timeline_event_id' => '00000702-7b19-4fa9-a77f-2a76172f5b99',
            'stakeholder_id' => '2r97a6d-5238-4fa9-a77f-2a76172f5b58',
            'inquiry' => 'Inquiry content 3',
            'created_at' => now(),
        ]);

        // Timeline Quire 2
        TimelineQuire::create([
            'id' => '58lm328-5238-4f11-a744-2a76172f5b77',
            'timeline_event_id' => '00000703-7b19-4fa9-a77f-2a76172f5b99',
            'stakeholder_id' => '1r97a6d-5236-4fa9-a77f-2a76172f5b58',
            'inquiry' => 'Inquiry content 4',
            'created_at' => now(),
        ]);


    }
}
