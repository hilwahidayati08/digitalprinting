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
 
            // Snapshot alamat pengiriman
            $table->text('shipping_address');
            $table->string('shipping_method'); // pickup, gojek, ekspedisi
 
            // Nominal
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
 
            // Member discount & komisi
            $table->decimal('discount_member', 12, 2)->default(0);
            $table->decimal('commission_earned', 12, 2)->default(0);
            $table->boolean('komisi_processed')->default(false);
            $table->decimal('komisi_digunakan', 12, 2)->default(0);
 
            // Pembayaran & Midtrans
            $table->string('payment_method')->nullable();
            $table->string('snap_token')->nullable();
 
            // Status workflow printing
            $table->enum('status', [
                'pending',       // Order masuk, menunggu pembayaran
                'paid',          // Sudah bayar
                'processing',    // Sedang diproses / dicetak
                'ready_pickup',  // Siap diambil (khusus pickup)
                'shipped',       // Dikirim (gojek/ekspedisi)
                'completed',     // Selesai / diterima
                'cancelled',     // Dibatalkan
            ])->default('pending');
 
            $table->boolean('stock_reduced')->default(false);
 
            // Tracking pengiriman
            $table->string('tracking_number')->nullable();
            $table->string('status_detail')->nullable();
            $table->string('kurir_name')->nullable();
            $table->dateTime('estimated_arrival')->nullable();
 
            // Timestamp status
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
 
            // Pembayaran cash
            $table->decimal('cash_amount_received', 15, 2)->nullable();
            $table->decimal('cash_change', 15, 2)->nullable();
 
            // Admin manual order
            $table->unsignedBigInteger('created_by')->nullable();
 
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
