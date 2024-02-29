<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name')->unique();
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['id', 'parent_id']);
        });

        // Insert statements for all categories
        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-446655440000',
            'name' => 'File',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-4466554400MP',
            'name' => 'ManualsAndPlans',
            'parent_id' => '003e8400-e29b-41d4-a716-446655440000',
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-44665544EDU',
            'name' => 'Education',
            'parent_id' => '003e8400-e29b-41d4-a716-446655440000',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-44665544OTH',
            'name' => 'Other',
            'parent_id' => '003e8400-e29b-41d4-a716-446655440000',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-44665544GAU',
            'name' => 'GuidelineAndUpdates',
            'parent_id' => '003e8400-e29b-41d4-a716-446655440000',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-44665544ISR',
            'name' => 'InfrastructureReports',
            'parent_id' => '003e8400-e29b-41d4-a716-446655440000',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '003e8400-e29b-41d4-a716-44665544WLR',
            'name' => 'WaterLevelReports',
            'parent_id' => '003e8400-e29b-41d4-a716-446655440000',
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '004e8400-e29b-41d4-a716-446655440000',
            'name' => 'About',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '005e8400-e29b-41d4-a716-446655440000',
            'name' => 'Contact Us',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
                'id' => '005e8400-e29b-4154-a716-446655440000',
                'name' => 'Project Description',
                'parent_id' => null,
                'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '006e8400-e29b-41d4-a716-446655440000',
            'name' => 'Notification',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '007e8400-e29b-41d4-a716-446655440000',
            'name' => 'Report',
            'parent_id' => null,
            'created_at' => now(),
        ]);


        DB::table('categories')->insert([
            'id' => '009e8400-e29b-41d4-a716-446655440000',
            'name' => 'Timeline Event',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        // Insert Primary categories
        DB::table('categories')->insert([
            'id' => '010e8400-e29b-41d4-a716-446655440000',
            'name' => 'Normal Production Rate',
            'parent_id' => '009e8400-e29b-41d4-a716-446655440000', // Timeline Event
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '011e8400-e29b-41d4-a716-446655440000',
            'name' => 'Extra Production Rate',
            'parent_id' => '009e8400-e29b-41d4-a716-446655440000', // Timeline Event
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '012e8400-e29b-41d4-a716-446655440000',
            'name' => 'Low Production Rate',
            'parent_id' => '009e8400-e29b-41d4-a716-446655440000', // Timeline Event
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '013e8400-e29b-41d4-a716-446655440000',
            'name' => 'Halted Production',
            'parent_id' => '009e8400-e29b-41d4-a716-446655440000', // Timeline Event
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '014e8400-e29b-41d4-a716-446655440000',
            'name' => 'Evacuating',
            'parent_id' => '009e8400-e29b-41d4-a716-446655440000', // Timeline Event
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '015e8400-e29b-41d4-a716-446655440000',
            'name' => 'Maintenance',
            'parent_id' => '009e8400-e29b-41d4-a716-446655440000', // Timeline Event
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '016e8400-e29b-41d4-a716-446655440000',
            'name' => 'Relocation',
            'parent_id' => '009e8400-e29b-41d4-a716-446655440000', // Timeline Event
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '017e8400-e29b-41d4-a716-446655440000',
            'name' => 'Product',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '018e8400-e29b-41d4-a716-446655440000',
            'name' => 'Route',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '019e8400-e29b-41d4-a716-446655440000',
            'name' => 'Material',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '020e8400-e29b-41d4-a716-446655440000',
            'name' => 'Station',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '021e8400-e29b-41d4-a716-446655440000',
            'name' => 'Supplier',
            'parent_id' => null,
            'created_at' => now(),
        ]);


        // Start Weather Notification
        DB::table('categories')->insert([
            'id' => '008e8400-e29b-41d4-a716-446655440000',
            'name' => 'Weather',
            'parent_id' => '006e8400-e29b-41d4-a716-446655440000', // Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '022e8400-e29b-41d4-a716-446655440000',
            'name' => 'Rain',
            'parent_id' => '008e8400-e29b-41d4-a716-446655440000', // Weather Notification
            'created_at' => now(),
        ]);

        // Notifications Categories
        DB::table('categories')->insert([
            'id' => '023e8400-e29b-41d4-a716-446655440000',
            'name' => 'Wind',
            'parent_id' => '008e8400-e29b-41d4-a716-446655440000', // Weather Notification
            'created_at' => now(),
        ]);

        // Notifications Categories
        DB::table('categories')->insert([
            'id' => '024e8400-e29b-41d4-a716-446655440000',
            'name' => 'Report Weather',
            'parent_id' => '008e8400-e29b-41d4-a716-446655440000', // Weather Notification
            'created_at' => now(),
        ]);
        // End Weather Notification

        // Start Water Level Notification
        DB::table('categories')->insert([
            'id' => '025e8400-e29b-41d4-a716-446655440000',
            'name' => 'Water Level',
            'parent_id' => '006e8400-e29b-41d4-a716-446655440000', // Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '026e8400-e29b-41d4-a716-446655440000',
            'name' => 'Monitoring Point',
            'parent_id' => '025e8400-e29b-41d4-a716-446655440000', // Water Level Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '027e8400-e29b-41d4-a716-446655440000',
            'name' => 'Dam',
            'parent_id' => '025e8400-e29b-41d4-a716-446655440000', // Water Level Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '028e8400-e29b-41d4-a716-446655440000',
            'name' => 'Report Water',
            'parent_id' => '025e8400-e29b-41d4-a716-446655440000', // Water Level Notification
            'created_at' => now(),
        ]);
        // End Water Level Notification

        // Start Infrastructure Notification
        DB::table('categories')->insert([
            'id' => '029e8400-e29b-41d4-a716-446655440000',
            'name' => 'Infrastructure Notification',
            'parent_id' => '006e8400-e29b-41d4-a716-446655440000', // Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '030e8400-e29b-41d4-a716-446655440000',
            'name' => 'Notifications',
            'parent_id' => '029e8400-e29b-41d4-a716-446655440000', // Infrastructure Notification
            'created_at' => now(),
        ]);
        // End Infrastructure Notification

        // Start Business Impact Notification
        DB::table('categories')->insert([
            'id' => '031e8400-e29b-41d4-a716-446655440000',
            'name' => 'Business Impact',
            'parent_id' => '006e8400-e29b-41d4-a716-446655440000', // Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '032e8400-e29b-41d4-a716-446655440000',
            'name' => 'Production Site',
            'parent_id' => '031e8400-e29b-41d4-a716-446655440000', // Business Impact Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '033e8400-e29b-41d4-a716-446655440000',
            'name' => 'Suppliers',
            'parent_id' => '031e8400-e29b-41d4-a716-446655440000', // Business Impact Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '034e8400-e29b-41d4-a716-446655440000',
            'name' => 'Wastes',
            'parent_id' => '031e8400-e29b-41d4-a716-446655440000', // Business Impact Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '035e8400-e29b-41d4-a716-446655440000',
            'name' => 'Shipments',
            'parent_id' => '031e8400-e29b-41d4-a716-446655440000', // Business Impact Notification
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '036e8400-e29b-41d4-a716-446655440000',
            'name' => 'Employees',
            'parent_id' => '031e8400-e29b-41d4-a716-446655440000', // Business Impact Notification
            'created_at' => now(),
        ]);

        // End Notification

        DB::table('categories')->insert([
            'id' => '037e8400-e29b-41d4-a716-446655440000',
            'name' => 'Customer',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '038e8400-e29b-41d4-a716-446655440000',
            'name' => 'Department',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '039e8400-e29b-41d4-a716-446655440000',
            'name' => 'Post',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '040e8400-e29b-41d4-a716-446655440000',
            'name' => 'News',
            'parent_id' => '039e8400-e29b-41d4-a716-446655440000', // Post
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '041e8400-e29b-41d4-a716-446655440000',
            'name' => 'Service',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '042e8400-e29b-41d4-a716-446655440000',
            'name' => 'Water Services',
            'parent_id' => '041e8400-e29b-41d4-a716-446655440000', // service
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '043e8400-e29b-41d4-a716-446655440000',
            'name' => 'Electricity Services',
            'parent_id' => '041e8400-e29b-41d4-a716-446655440000', // service
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '044e8400-e29b-41d4-a716-446655440000',
            'name' => 'Sanitation Services',
            'parent_id' => '041e8400-e29b-41d4-a716-446655440000', // service
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '045e8400-e29b-41d4-a716-446655440000',
            'name' => 'Communication Services',
            'parent_id' => '041e8400-e29b-41d4-a716-446655440000', // service
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '046e8400-e29b-41d4-a716-446655440000',
            'name' => 'Emergency Services',
            'parent_id' => '041e8400-e29b-41d4-a716-446655440000', // service
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '047e8400-e29b-41d4-a716-446655440000',
            'name' => 'Public Transportation Services',
            'parent_id' => '041e8400-e29b-41d4-a716-446655440000', // service
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '048e8400-e29b-41d4-a716-446655440000',
            'name' => 'Waste Disposal Site',
            'parent_id' => null,
            'created_at' => now(),
        ]);

        DB::table('categories')->insert([
            'id' => '048e9200-e29b-41d4-a716-446655440000',
            'name' => 'Announcements',
            'parent_id' => null,
            'created_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
