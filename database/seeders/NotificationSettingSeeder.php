<?php

namespace Database\Seeders;

use App\Models\Notifications\NotificationsSetting;
use Illuminate\Database\Seeder;

class NotificationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Notification Settings for Portal Manager
        NotificationsSetting::create([
            'id' => '00p17a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "022e8400-e29b-41d4-a716-446655440000", // rain
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '00P16a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "023e8400-e29b-41d4-a716-446655440000", // rain
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '00P16O6g-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "024e8400-e29b-41d4-a716-446655440000", // rain
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '00P1646g-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "025e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "026e8400-e29b-41d4-a716-446655440000", // rain
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P1646g-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "025e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "027e8400-e29b-41d4-a716-446655440000", // rain
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P3946g-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "025e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "028e8400-e29b-41d4-a716-446655440000", // rain
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P1946g-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "029e8400-e29b-41d4-a716-446655440000", // Infrastructure
            'sub_category_id' => "030e8400-e29b-41d4-a716-446655440000", // notification
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P19H6g-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "031e8400-e29b-41d4-a716-446655440000", // Infrastructure
            'sub_category_id' => "032e8400-e29b-41d4-a716-446655440000", // notification
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P19H6g-7b7K-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "031e8400-e29b-41d4-a716-446655440000", // Infrastructure
            'sub_category_id' => "033e8400-e29b-41d4-a716-446655440000", // notification
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P19H6g-7b7L-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "031e8400-e29b-41d4-a716-446655440000", // Infrastructure
            'sub_category_id' => "034e8400-e29b-41d4-a716-446655440000", // notification
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P19H6g-7bpL-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "031e8400-e29b-41d4-a716-446655440000", // Infrastructure
            'sub_category_id' => "035e8400-e29b-41d4-a716-446655440000", // notification
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        NotificationsSetting::create([
            'id' => '07P19G6g-7bpL-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Portal Manager
            'main_category_id' => "031e8400-e29b-41d4-a716-446655440000", // Infrastructure
            'sub_category_id' => "036e8400-e29b-41d4-a716-446655440000", // notification
            'notification_state' => 'none',
            'notification_level' => 'high',
            'notification_priorities' => 'high',
            'is_on' => true,
            'note' => 'Notification settings for Portal Manager',
        ]);

        // Notification Settings for Tenant Company (First)
        NotificationsSetting::create([
            'id' => '00p27a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '12c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Tenant Company (First)
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "023e8400-e29b-41d4-a716-446655440000", // wind
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => false,
            'note' => 'Notification settings for Tenant Company (First)',
        ]);

        // Notification Settings for Tenant Company (Second)
        NotificationsSetting::create([
            'id' => '00p37a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Tenant Company (Second)
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "024e8400-e29b-41d4-a716-446655440000", // report
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => true,
            'note' => 'Notification settings for Tenant Company (Second)',
        ]);


        // Notification Settings for Industrial Area Representative (First)
        NotificationsSetting::create([
            'id' => '00p47a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Industrial Area Representative (First)
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "024e8400-e29b-41d4-a716-446655440000", // report
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => false,
            'note' => 'Notification settings for Industrial Area Representative (First)',
        ]);

        // Notification Settings for Industrial Area Representative (Second)
        NotificationsSetting::create([
            'id' => '00p57a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '15c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Industrial Area Representative (Second)
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "024e8400-e29b-41d4-a716-446655440000", // report
            'notification_state' => 'none',
            'notification_level' => 'none',
            'notification_priorities' => 'none',
            'is_on' => true,
            'note' => 'Notification settings for Industrial Area Representative (Second)',
        ]);

        // Notification Settings for Infrastructure Provider
        NotificationsSetting::create([
            'id' => '00p67a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '16c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Infrastructure Provider
            'main_category_id' => "008e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "024e8400-e29b-41d4-a716-446655440000", // report
            'notification_state' => 'observation',
            'notification_level' => 'normal',
            'notification_priorities' => 'top',
            'is_on' => false,
            'note' => 'Notification settings for Infrastructure Provider',
        ]);

        // Notification Settings for Government Representative
        NotificationsSetting::create([
            'id' => '00p77a6d-7b19-4fa9-1234-2a76172f5b58', // Generate a unique ID
            'user_id' => '17c97a6d-7b19-4fa9-a77f-2a76172f5b58', // User ID for Government Representative
            'main_category_id' => "025e8400-e29b-41d4-a716-446655440000", // weather
            'sub_category_id' => "028e8400-e29b-41d4-a716-446655440000", // report
            'notification_state' => 'forecasting',
            'notification_level' => 'none',
            'notification_priorities' => 'high',
            'is_on' => false,
            'note' => 'Notification settings for Government Representative',
        ]);
    }
}
