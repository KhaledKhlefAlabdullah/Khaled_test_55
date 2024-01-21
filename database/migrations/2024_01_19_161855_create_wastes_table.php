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
        Schema::create('wastes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(\Illuminate\Support\Str::uuid())->unique();
            $table->string('route_id');
            $table->string('waste_disposal_location_id');
            $table->string('stakeholder_id');
            $table->string('waste_name');
            $table->text('location');
            $table->text('contact_info');
            $table->foreign('route_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('waste_disposal_location_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
