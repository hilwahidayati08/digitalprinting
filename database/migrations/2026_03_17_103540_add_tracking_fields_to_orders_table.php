<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up() {
    Schema::table('orders', function (Blueprint $table) {
        $table->string('status_detail')->nullable();   // Pesan progres
        $table->string('kurir_name')->nullable();     // Nama kurir Anda
        $table->dateTime('estimated_arrival')->nullable(); // Estimasi jam sampai
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
