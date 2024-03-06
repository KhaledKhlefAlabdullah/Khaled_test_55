<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_resources', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('event_id');
            $table->string('resource_id');
            $table->foreign('event_id')->references('id')->on('timeline_events')->onDelete('cascade');
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_resources');
    }
};
