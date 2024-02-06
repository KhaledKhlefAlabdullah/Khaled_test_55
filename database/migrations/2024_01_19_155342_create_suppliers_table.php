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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('route_id');
            $table->string('material_id');
            $table->string('stakeholder_id');
            $table->string('public_id')->unique();
            $table->text('location');
            $table->text('contact_info');
            $table->string('slug')->nullable();
            $table->boolean('is_available');
            $table->foreign('route_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
