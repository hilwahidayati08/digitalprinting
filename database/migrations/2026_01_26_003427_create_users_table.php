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
        $table->string('username', 100);
        $table->string('useremail', 100)->unique();
        
        // PENTING: Ubah ke minimal 100 atau 255 karakter untuk password hashed
        $table->string('password'); 
        
        $table->string('no_telp', 22)->nullable();
        $table->enum('role', ['admin', 'user'])->default('user');
        
        // rememberToken() otomatis membuat kolom 'remember_token' (string 100)
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
