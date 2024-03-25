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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('user_id');
            $table->string('main_category_id');
            $table->string('sub_category_id');
            $table->string('title');
            $table->string('tags')->nullable();
            $table->text('description');
            $table->string('version')->nullable();
            $table->string('media_url')->nullable();
            $table->enum('media_type', ['image', 'video', 'file'])->nullable();
            $table->enum('update_frequency', ['daily', 'weekly', 'monthly'])->nullable();
            $table->enum('update_state', ['Up to date','overdue'])->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('main_category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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
