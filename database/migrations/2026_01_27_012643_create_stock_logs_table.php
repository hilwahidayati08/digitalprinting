<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('stock_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('material_id')->constrained('materials', 'material_id')->onDelete('cascade');
        $table->enum('type', ['in', 'out']); // 'in' (masuk/restock), 'out' (keluar/order)
        $table->double('amount'); // Jumlah yang berubah
        $table->double('last_stock'); // Saldo stok terakhir
        $table->string('description')->nullable(); // Ket: "Order #INV-001" atau "Restock"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
