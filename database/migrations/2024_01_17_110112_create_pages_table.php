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
        Schema::create('pages', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('portal_setting_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('location')->nullable();
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->foreign('portal_setting_id')->references('id')->on('portal_settings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
