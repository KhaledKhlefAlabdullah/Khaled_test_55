<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new  class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('stakeholder_id');
            $table->string('category_id');
            $table->string('name')->nullable();
            $table->string('public_id');
            $table->string('phone_number')->nullable();
            $table->text('location')->nullable();
            $table->text('from')->nullable();
            $table->text('to')->nullable();
            $table->string('usage')->nullable();
            $table->float('quantity')->nullable();
            $table->boolean('is_available')->nullable();
            $table->float('available_quantity')->nullable();
            $table->text('note')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['public_id', 'stakeholder_id']);
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
