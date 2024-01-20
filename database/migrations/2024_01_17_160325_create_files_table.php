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
            $table->string('id')->primary()->unique()->default(str_replace(['/','\\'], '-', \Illuminate\Support\Facades\Hash::make(now())));
            $table->string('user_id');
            $table->string('category_id');
            $table->enum('file_type',['Educational', 'Manuals', 'Plans']);
            $table->string('title');
            $table->text('description');
            $table->string('version')->nullable();
            $table->string('media_URL')->nullable();
            $table->enum('media_type',['image','video','file'])->nullable();
            $table->enum('update_frequency',['daily','weekly','monthly'])->nullable();
            $table->date('deleted_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
