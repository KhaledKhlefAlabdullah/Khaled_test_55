<?php

namespace Database\Seeders;

use App\Models\Notifications\Notifications_setting;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Notification Settings for Portal Manager
        Notifications_setting::create([
            'id' => '00p17a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "34c97a6d-7b19-4fa9-a77f-2a76172f5b22",
            'sub_category_id' => "11197a6d-7b19-4fa9-a77f-2a76172f5b22",
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        // Notification Settings for Tenant Company (First)
        Notifications_setting::create([
            'id' => '00p27a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Tenant Company (First)
            'main_category_id' => "34c97a6d-7b19-4fa9-a77f-2a76172f5b22",
            'sub_category_id' => "11197a6d-7b19-4fa9-a77f-2a76172f5b22",
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => false,
            'note' => 'Notification settings for Tenant Company (First)',
        ]);

        // Notification Settings for Tenant Company (Second)
        Notifications_setting::create([
            'id' => '00p37a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Tenant Company (Second)
            'main_category_id' => "34c97a6d-7b19-4fa9-a77f-2a76172f5b22",
            'sub_category_id' => "11197a6d-7b19-4fa9-a77f-2a76172f5b22",
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => true,
            'note' => 'Notification settings for Tenant Company (Second)',
        ]);

        // Notification Settings for Industrial Area Representative (First)
        Notifications_setting::create([
            'id' => '00p47a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Industrial Area Representative (First)
            'main_category_id' => "34c97a6d-7b19-4fa9-a77f-2a76172f5b22",
            'sub_category_id' => "11197a6d-7b19-4fa9-a77f-2a76172f5b22",
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => false,
            'note' => 'Notification settings for Industrial Area Representative (First)',
        ]);

        // Notification Settings for Industrial Area Representative (Second)
        Notifications_setting::create([
            'id' => '00p57a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '15c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Industrial Area Representative (Second)
            'main_category_id' => "34c97a6d-7b19-4fa9-a77f-2a76172f5b22",
            'sub_category_id' => "11197a6d-7b19-4fa9-a77f-2a76172f5b22",
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => true,
            'note' => 'Notification settings for Industrial Area Representative (Second)',
        ]);

        // Notification Settings for Infrastructure Provider
        Notifications_setting::create([
            'id' => '00p67a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '16c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Infrastructure Provider
            'main_category_id' => "34c97a6d-7b19-4fa9-a77f-2a76172f5b22",
            'sub_category_id' => "23237a6d-7b19-4fa9-a77f-2a76172f5b22",
            'notification_state' => 'observation',
            'notification_level' => 'normal',
            'notification_priorities' => 'top',
            'is_on' => false,
            'note' => 'Notification settings for Infrastructure Provider',
        ]);

        // Notification Settings for Government Representative
        Notifications_setting::create([
            'id' => '00p77a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '17c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Government Representative
            'main_category_id' => "34c97a6d-7b19-4fa9-a77f-2a76172f5b22",
            'sub_category_id' => "23237a6d-7b19-4fa9-a77f-2a76172f5b22",
            'notification_state' => 'forecasting',
            'notification_level' => 'none',
            'notification_priorities' => 'high',
            'is_on' => false,
            'note' => 'Notification settings for Government Representative',
        ]);
    }
}
