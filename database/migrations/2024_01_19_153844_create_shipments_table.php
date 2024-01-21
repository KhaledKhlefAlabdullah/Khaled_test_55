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
        Schema::create('shipments', function (Blueprint $table) {
            $table->string('id')->primary()->unique()->default(str_replace(['/','\\'], '-', \Illuminate\Support\Facades\Hash::make(now())));
            $table->string('route_id');
            $table->string('product_id');
            $table->string('customer_id');
            $table->string('stakeholder_id');
            $table->integer('public_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('location');
            $table->text('contact_info');
            $table->foreign('route_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
