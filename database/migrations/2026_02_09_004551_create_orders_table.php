<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id('order_id');
        $table->foreignId('user_id')->constrained('users', 'user_id');
        $table->string('order_number')->unique();

        // Snapshot alamat
        $table->text('shipping_address');
            $table->string('shipping_method'); // gojek, ekspedisi, pickup

        // Nominal
        $table->decimal('subtotal', 12, 2);
        $table->decimal('tax', 12, 2)->default(0);
        $table->decimal('shipping_cost', 12, 2)->default(0);
        $table->decimal('total', 12, 2);

        // Pembayaran & Midtrans
        $table->string('payment_method')->nullable();
        $table->string('payment_proof')->nullable(); 
        $table->string('snap_token')->nullable();

        // Status workflow printing
        $table->enum('status', [
            'pending',          // Order masuk
            'waiting_payment',  // Menunggu bayar
            'paid',             // Sudah bayar
            'processing',       // Diproses (Admin sedang cetak)
            'shipped',          // Dikirim
            'delivered',        // Diterima
            'cancelled',        // Dibatalkan
        ])->default('pending');

        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
