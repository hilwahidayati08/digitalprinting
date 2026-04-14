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
 
            $table->decimal('width_cm', 10, 2)->nullable();
            $table->decimal('height_cm', 10, 2)->nullable();
            $table->decimal('used_material_qty', 10, 2)->nullable(); // khusus stiker nesting
 
            $table->integer('qty');
            $table->integer('total_yield_pcs')->nullable();
 
            $table->decimal('unit_price', 15, 2); // harga dasar saat transaksi
            $table->decimal('subtotal', 15, 2);
 
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
