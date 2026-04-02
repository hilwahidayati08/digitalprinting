<?php	

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saldo_logs', function (Blueprint $table) {
            $table->id('saldo_log_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');

            // credit = saldo masuk | debit = saldo keluar
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 12, 2);
            $table->decimal('saldo_before', 12, 2);  // Saldo sebelum transaksi
            $table->decimal('saldo_after', 12, 2);   // Saldo sesudah transaksi

            $table->string('description')->nullable();
            // Contoh: 'Komisi dari order #ORD-001'
            // Contoh: 'Withdraw ke BCA 1234567890'
            // Contoh: 'Digunakan untuk order #ORD-002'

            $table->string('reference_type')->nullable();  // 'order' / 'withdrawal'
            $table->unsignedBigInteger('reference_id')->nullable(); // order_id / withdrawal_id

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo_logs');
    }
};
