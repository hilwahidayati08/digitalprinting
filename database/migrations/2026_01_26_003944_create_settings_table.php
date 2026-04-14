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
        Schema::create('settings', function (Blueprint $table) {
            $table->id('setting_id');
 
            $table->string('whatsapp', 20)->nullable();
            $table->string('email')->nullable();
 
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
 
            $table->time('time_open')->nullable();
            $table->time('time_close')->nullable();
            $table->text('address')->nullable();
 
            // Member tier system
            $table->integer('member_min_orders')->default(5)->comment('Minimal jumlah order untuk bisa ajukan member');
            $table->decimal('member_min_spent', 15, 2)->default(500000)->comment('Minimal total belanja untuk bisa ajukan member');
 
            $table->decimal('rate_regular', 5, 2)->default(5)->comment('Diskon % untuk tier Regular');
            $table->decimal('rate_plus', 5, 2)->default(10)->comment('Diskon % untuk tier Plus');
            $table->decimal('rate_premium', 5, 2)->default(15)->comment('Diskon % untuk tier Premium');
 
            $table->decimal('tier_plus_min', 15, 2)->default(1000000)->comment('Min. total belanja untuk naik ke tier Plus');
            $table->decimal('tier_premium_min', 15, 2)->default(5000000)->comment('Min. total belanja untuk naik ke tier Premium');
 
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
