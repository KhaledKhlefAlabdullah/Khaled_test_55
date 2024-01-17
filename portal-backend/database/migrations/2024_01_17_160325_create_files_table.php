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
        Schema::create('files', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('user_id');
            $table->string('category_id');
            $table->enum('file_type',['Educational', 'Manuals', 'Plans']);
            $table->string('title');
            $table->text('description');
            $table->string('version');
            $table->string('file_URL');
            $table->string('image_URL');
            $table->string('video_URL');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('post_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
