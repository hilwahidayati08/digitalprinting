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
Schema::create('order_items', function (Blueprint $table) {
    $table->id('order_item_id');
    $table->foreignId('product_id')->constrained('products', 'product_id');
    $table->foreignId('order_id')->constrained('orders', 'order_id')->onDelete('cascade');
    $table->foreignId('finishing_id')->nullable()->constrained('finishing_options', 'finishing_id');
    // Input Kustom User
    $table->decimal('width_cm', 10, 2)->nullable();
    $table->decimal('height_cm', 10, 2)->nullable();
    
    // Hasil Hitungan
    $table->integer('qty'); // Jumlah lembar/pcs yang dipesan
    $table->integer('total_yield_pcs')->nullable(); // Total stiker yg didapat (jika tipe stiker)
        /*
khusus stiker nesting    */
    $table->decimal('used_material_qty', 10, 2)->nullable();
    // Harga
    $table->decimal('unit_price', 15, 2); // Harga dasar saat transaksi
    $table->decimal('subtotal', 15, 2);   // (Unit Price * Qty) atau (Unit Price * Luas)

    // File & Catatan
    $table->string('design_file')->nullable();
    $table->text('design_link')->nullable();
    $table->text('notes')->nullable(); 

    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
