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
        Schema::create('stakeholders', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(\Illuminate\Support\Str::uuid())->unique();
            $table->string('user_id');
            $table->string('industrial_area_id');
            $table->string('representative_government_agency')->nullable();
            $table->enum('tent_company_state',['operating','evacuating','trapped','evacuated'])->nullable();
            $table->string('company_representative_name')->nullable();
            $table->string('job_title')->nullable();
            $table->enum('infrastructures_state',['available','partially','interrupted'])->nullable();
            $table->string('infrastructure_type')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('industrial_area_id')->references('id')->on('industrial_areas')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staheholders');
    }
};
