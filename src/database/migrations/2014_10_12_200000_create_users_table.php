<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('industrial_area_id')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('stakeholder_type', ['Tenant_company', 'Portal_manager', 'Industrial_area_representative', 'Infrastructure_provider', 'Government_representative'])->default('Tenant_company');
            $table->boolean('is_active')->default(false);
            $table->foreign('industrial_area_id')->references('id')->on('industrial_areas')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        $password = password_hash('123', PASSWORD_DEFAULT);
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'email' => 'test@example.com',
            'password' => $password,
            'stakeholder_type' => 'Portal_manager',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
