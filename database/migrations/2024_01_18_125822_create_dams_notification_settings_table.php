<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dams_notification_settings', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('dam_id');
            $table->string('notification_setting_id');
            $table->foreign('dam_id')->references('id')->on('dams')->onDelete('cascade');
            $table->foreign('notification_setting_id')->references('id')->on('notifications_settings')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            // Add unique constraint across both columns
            $table->unique(['dam_id', 'notification_setting_id'], 'unique_dam_notification_setting');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dam_notification_settings');
    }
};
