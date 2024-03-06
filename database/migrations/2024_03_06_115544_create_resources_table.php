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
        Schema::create('resources', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('stakeholder_id');
            $table->string('resource');
            $table->float('quantity');
            $table->boolean('is_avilable')->default('true');
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['stakeholder_id','resource']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
