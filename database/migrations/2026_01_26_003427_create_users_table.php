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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
 
            $table->string('google_id')->nullable();
            $table->string('username', 100);
            $table->string('full_name')->nullable();
            $table->string('useremail', 100)->nullable()->unique();
            $table->string('password')->nullable(); // nullable untuk user Google
            $table->string('no_telp', 22)->nullable();
            $table->enum('role', ['admin', 'user'])->default('user');
 
            // Member system
            $table->boolean('is_member')->default(false);
            $table->enum('member_tier', ['regular', 'plus', 'premium'])->default('regular');
            $table->decimal('total_spent', 15, 2)->default(0)->comment('Total belanja kumulatif untuk hitung naik tier');
            $table->decimal('saldo_komisi', 12, 2)->default(0);
 
            $table->rememberToken();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
