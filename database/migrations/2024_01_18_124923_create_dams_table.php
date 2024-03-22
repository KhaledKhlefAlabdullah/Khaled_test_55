<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dams', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('user_id')->nullable();
            $table->string('name');
            $table->string('location');
            $table->float('water_level');
            $table->string('discharge');
            $table->string('source')->nullable();
            $table->text('dam_data')->nullable();
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
        Schema::dropIfExists('dams');
    }
};
