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
        Schema::create('password_reset_otps', function (Blueprint $table) {
            $table->id('otp_id');
            $table->string('useremail')->index();
            $table->string('otp_code', 6);
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamps();
 
            $table->foreign('useremail')
                  ->references('useremail')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key dulu baru drop table
        Schema::table('password_reset_otps', function (Blueprint $table) {
            $table->dropForeign(['useremail']);
        });
        
        Schema::dropIfExists('password_reset_otps');
    }
};