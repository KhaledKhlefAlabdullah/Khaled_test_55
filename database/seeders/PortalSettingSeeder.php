<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('portal_settings')->insert([
            'id' => "1pp87a6d-7b19-4fa9-a77f-2a76172f5b97",
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'key' => "Facebook URL",
            'value' => "https://facebook.com/portal",
            'created_at' => now()

        ]);

        DB::table('portal_settings')->insert([
            'id' => "2pp87a6d-7b19-4fa9-a77f-2a76172f5b97",
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'key' => "Logo",
            'value' => "logo.png",
            'created_at' => now()

        ]);


        DB::table('portal_settings')->insert([
            'id' => "3pp87a6d-7b19-4fa9-a77f-2a76172f5b97",
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'key' => "Title",
            'value' => "I'm Portal Value",
            'created_at' => now()

        ]);


        DB::table('portal_settings')->insert([
            'id' => "4pp87a6d-7b19-4fa9-a77f-2a76172f5b97",
            'user_id' => "12c97a6d-7b19-4fa9-a77f-2a76172f5b58",
            'key' => "Phone Number",
            'value' => "+90 1252525895",
            'created_at' => now()
        ]);
    }
}
