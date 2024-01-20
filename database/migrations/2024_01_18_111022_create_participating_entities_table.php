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
        Schema::create('participating_entities', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('user_id');
            $table->string('title')->nullable();
            $table->string('media_URL');
            $table->enum('media_type', ['image', 'video', 'file', 'website_URL'])->nullable();
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
        Schema::dropIfExists('participating_entities');
    }
};
