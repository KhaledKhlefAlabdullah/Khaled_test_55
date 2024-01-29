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
        Schema::create('disaster_reports', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('natural_disaster_id');
            $table->string('entity_id')->nullable();
            $table->string('shipment_id')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('employee_id')->nullable();
            $table->string('waste_id')->nullable();
            $table->boolean('is_safe')->default(false);
            $table->date('impact_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('stop_date')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('natural_disaster_id')->references('id')->on('natural_disasters')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('waste_id')->references('id')->on('wastes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_reports');
    }
};
