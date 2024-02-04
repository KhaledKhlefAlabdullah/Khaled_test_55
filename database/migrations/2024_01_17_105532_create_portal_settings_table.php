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
        Schema::create('portal_settings', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('key');
            $table->text('value');
//            $table->text('icon')->nullable();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

//        // Project Title
//        DB::table('portal_settings')->insert([
//            'id' => '01cb5a6d-7b19-4fa9-a77f-2a76172f5b58',
//            'key' => 'project-title',
//            'value' => '',
//        ]);
//
//        // Project Description
//        DB::table('portal_settings')->insert([
//            'id' => '02cb5a6d-7b19-4fa9-a77f-2a76172f5b58',
//            'key' => 'project-description',
//            'value' => '',
//        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_settings');
    }
};
