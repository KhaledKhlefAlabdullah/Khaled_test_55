<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->primary()->unique()->default(str_replace(['/','\\'], '-', \Illuminate\Support\Facades\Hash::make(now())));
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('stakeholder_type',['Tenant Company', 'Portal Manager', 'Industrial Area Representative', 'Infrastructure Provider', 'Government Representative']);
            $table->boolean('isActive');
            $table->date('deleted_at');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        $password=password_hash('123',PASSWORD_DEFAULT);
        DB::table('users')->insert([
            'email'=>'test@example.com',
            'password'=>$password,
            'stakeholder_type'=>'Tenant_Company',
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
