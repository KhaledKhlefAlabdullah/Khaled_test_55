<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First notification seed
        DB::table('notifications')->insert([
            'id' => '1a97a6d-0202-4fa9-a77f-2a76172f0b58',
            'user_id' => '15c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'New Email Notification',
            'description' => 'You have received a new email.',
            'slug' => 'new-email-notification',
            'is_read' => false,
            'notification_type' => 'email',
            'created_at' => now(),

        ]);

// Second notification seed
        DB::table('notifications')->insert([
            'id' => '2a97a6d-0202-4fa9-a77f-2a7617205b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'New SMS Notification',
            'description' => 'You have received a new SMS message.',
            'slug' => 'new-sms-notification',
            'is_read' => false,
            'notification_type' => 'sms',
            'created_at' => now(),

        ]);

// Third notification seed
        DB::table('notifications')->insert([
            'id' => '3a97a6d-0202-4fa9-077f-2a76172f5b58',
            'user_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'New App Notification',
            'description' => 'You have a new notification in the app.',
            'slug' => 'new-app-notification',
            'is_read' => true,
            'notification_type' => 'notification',
            'created_at' => now(),

        ]);

        // Fourth notification seed
        DB::table('notifications')->insert([
            'id' => '4a97a6d-0202-4fa9-a77f-2076172f5b58',
            'user_id' => '13c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'Important System Update',
            'description' => 'There is an important system update. Please review the details.',
            'slug' => 'important-system-update',
            'is_read' => false,
            'notification_type' => 'notification',
            'created_at' => now(),

        ]);

        // Fifth notification seed
        DB::table('notifications')->insert([
            'id' => '5a97a6d-0202-4f09-a77f-2a76172f5b58',
            'user_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'Account Expiry Warning',
            'description' => 'Your account subscription is about to expire. Renew now to avoid disruption.',
            'slug' => 'account-expiry-warning',
            'is_read' => false,
            'notification_type' => 'email',
            'created_at' => now(),

        ]);

        // Sixth notification seed
        DB::table('notifications')->insert([
            'id' => '6a9706d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '19997a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'New Article Notification',
            'description' => 'A new article has been published on our website. Read it now!',
            'slug' => 'new-article-notification',
            'is_read' => false,
            'notification_type' => 'notification',
            'created_at' => now(),

        ]);

// Seventh notification seed
        DB::table('notifications')->insert([
            'id' => '7a90a6d-7b19-4fa9-a77f-2a76172f5b58',
            'user_id' => '17c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'Payment Received',
            'description' => 'Your recent payment has been successfully received. Thank you!',
            'slug' => 'payment-received',
            'is_read' => true,
            'notification_type' => 'email',
            'created_at' => now(),

        ]);

// Eighth notification seed
        DB::table('notifications')->insert([
            'id' => '8a97a6d-7b19-4fa9-a70f-2a76172f5b58',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'New Task Assigned',
            'description' => 'You have been assigned a new task. Check the details in your task list.',
            'slug' => 'new-task-assigned',
            'is_read' => false,
            'notification_type' => 'notification',
            'created_at' => now(),

        ]);

// Ninth notification seed
        DB::table('notifications')->insert([
            'id' => '9a97a6d-7b19-4f09-a77f-2a76172f5b58',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'Event Reminder',
            'description' => 'Reminder: Tomorrow is the big event. Don\'t forget to attend!',
            'slug' => 'event-reminder',
            'is_read' => false,
            'notification_type' => 'notification',
            'created_at' => now(),

        ]);

// Tenth notification seed
        DB::table('notifications')->insert([
            'id' => '10a97a6d-7b19-40a9-a77f-2a76172f5b58',
            'user_id' => '14c97a6d-7b19-4fa9-a77f-2a76172f5b58',
            'title' => 'New Product Announcement',
            'description' => 'Exciting news! We are launching a new product. Stay tuned for details.',
            'slug' => 'new-product-announcement',
            'is_read' => false,
            'notification_type' => 'notification',
            'created_at' => now(),

        ]);


    }
}
