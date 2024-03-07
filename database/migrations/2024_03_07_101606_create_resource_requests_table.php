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
         
        Schema::create('resource_requests', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('sender_stakeholder_id');
            $table->string('receiver_stakeholder_id');
            $table->string('resource_id');
            $table->enum('request_state',['pending','accept','reject'])->default('pending');
            $table->float('quantity');
            $table->foreign('sender_stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->foreign('receiver_stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
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
        Schema::dropIfExists('resource_requests');
    }
};
