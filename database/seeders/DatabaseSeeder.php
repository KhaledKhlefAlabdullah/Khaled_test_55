<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders
        $this->call([
            IndustrialAreaSeeder::class,
            UserSeeder::class,
            UserProfileSeeder::class,
            //  CategorySeeder::class,
            DamSeeder::class,
            StakeholderSeeder::class,
            RegistrationRequestSeeder::class,
            PortalSettingSeeder::class,
            ParticipatingEntitiesSeeder::class,
            PageSeeder::class,
            ContactUsMessageSeeder::class,
            EntitiesSeeder::class,
            FileSeeder::class,
            NotificationSeeder::class,
            NotificationSettingSeeder::class,
            TimelineSeeder::class,
            TimelineEventSeeder::class,
            TimelineQuireSeeder::class,
            TimelineShareRequestSeeder::class,
            WasteSeeder::class,
            PostSeeder::class,
            SupplierSeeder::class,
            ShipmentSeeder::class,
            ServiceSeeder::class,
            NaturalDisasterSeeder::class,
            MonitoringPointSeeder::class,
            ResidentialAreaSeeder::class,
            EmployeeSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
            DisasterReportSeeder::class,
        ]);

        // Factory
        //        User::factory()->count(10)->create();
        //        Page::factory()->count(10)->create();
        //        Contact_us_message::factory()->count(10)->create();
        //        Category::factory()->count(10)->create();
        //        Post::factory()->count(10)->create();
        //        Chat::factory()->count(10)->create();
        //        Message::factory()->count(10)->create();

    }
}
