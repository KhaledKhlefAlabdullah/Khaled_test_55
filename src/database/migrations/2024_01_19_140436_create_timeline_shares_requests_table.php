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
        Schema::create('timeline_shares_requests', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('timeline_id');
            $table->string('send_stakeholder_id');
            $table->string('receive_stakeholder_id');
            $table->enum('status', ['accept', 'reject', 'pending'])->default('pending');
            $table->date('send_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreign('timeline_id')->references('id')->on('timelines')->onDelete('cascade');
            $table->foreign('send_stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->foreign('receive_stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeline_shares_requests');
    }
};
