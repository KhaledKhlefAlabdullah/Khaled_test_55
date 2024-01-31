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
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('stakeholder_id');
            $table->string('route_id');
            $table->string('department_id');
            $table->string('station_id');
            $table->string('residential_area_id');
            $table->integer('employee_number')->unique();
            $table->boolean('is_leadership');
            $table->string('slug')->nullable();
            $table->foreign('route_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->foreign('residential_area_id')->references('id')->on('residential_areas')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
