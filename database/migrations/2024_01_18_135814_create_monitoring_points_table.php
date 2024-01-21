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
        Schema::create('monitoring_points', function (Blueprint $table) {
            $table->string('id')->primary()->unique()->default(str_replace(['/','\\'], '-', \Illuminate\Support\Facades\Hash::make(now())));
            $table->string('user_id');
            $table->string('name');
            $table->string('location');
            $table->enum('point_type',['normal','high','dangerous']);
            $table->text('API_link')->nullable();
            $table->boolean('is_custom')->default(false);
            $table->double('water_level')->nullable();
            $table->string('risk_indicators')->nullable();
            $table->string('discharge')->nullable();
            $table->string('source')->nullable();
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
        Schema::dropIfExists('monitoring_points');
    }
};
