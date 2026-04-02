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
    Schema::create('cart_items', function (Blueprint $table) {
        $table->id('cart_item_id');
        $table->foreignId('cart_id')->constrained('carts', 'cart_id')->onDelete('cascade');
        $table->foreignId('product_id')->constrained('products', 'product_id');

        // Input Kustom User (Sama persis dengan order_items)
    // Input ukuran dari user
    $table->decimal('width_cm', 10, 2)->nullable();
    $table->decimal('height_cm', 10, 2)->nullable();
    $table->decimal('used_material_qty', 10, 2)->nullable();

        
        // Hasil Hitungan (Sama persis dengan order_items)
        $table->integer('qty'); // Jumlah lembar/pcs yang dipesan
        $table->integer('total_yield_pcs')->nullable(); // Total stiker yg didapat (jika tipe stiker)
        
        // Harga (Sama persis dengan order_items: 15, 2)
        $table->decimal('price', 15, 2);    // Menggunakan 'price' untuk unit_price
        $table->decimal('subtotal', 15, 2); // (Price * Qty) atau (Price * Luas)

        // Catatan (Sesuai order_items)
        $table->text('notes')->nullable(); 

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
