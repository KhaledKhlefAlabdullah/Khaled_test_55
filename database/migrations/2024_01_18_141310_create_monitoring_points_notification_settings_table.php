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
        Schema::create('monitoring_points_notification_settings', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->string('monitoring_point_id');
            $table->string('notifications_setting_id');
            $table->foreign('monitoring_point_id', 'monitoring_point_id')->references('id')->on('monitoring_points')->onDelete('cascade');
            $table->foreign('notifications_setting_id','notifications_setting_id')->references('id')->on('notifications_settings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_points_notification_settings');
    }
};



