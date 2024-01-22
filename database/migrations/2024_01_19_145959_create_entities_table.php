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
        Schema::create('entities', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('stakeholder_id');
            $table->string('category_id');
            $table->string('name');
            $table->string('slug');
            $table->integer('public_id')->unique();
            $table->string('phone_number')->nullable();
            $table->text('location')->nullable();
            $table->text('from')->nullable();
            $table->text('to')->nullable();
            $table->string('usage')->nullable();
            $table->boolean('quantity')->nullable();
            $table->boolean('is_available')->nullable();
            $table->boolean('available_quantity')->nullable();
            $table->text('note')->nullable();
            $table->text('description')->nullable();
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
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
        Schema::dropIfExists('entities');
    }
};
