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
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('user_id');
            $table->string('page_id');
            $table->string('category_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('body');
            $table->string('media_url')->nullable();
            $table->enum('media_type', ['image', 'video', 'file'])->nullable();
            $table->boolean('is_priority')->nullable();
            $table->integer('priority_count')->nullable();
            $table->boolean('is_general_news')->default(false);
            $table->boolean('is_publish')->default(false);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
