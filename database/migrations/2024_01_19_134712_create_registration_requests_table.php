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
        Schema::create('registration_requests', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('user_id');
            $table->string('name');
            $table->string('representative_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('location');
            $table->string('phone_number');
            $table->string('job_title');
            $table->enum('request_state',['accepted','failed','pending'])->default('pending');
            $table->string('failed_message')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regiatration_requests');
    }
};
