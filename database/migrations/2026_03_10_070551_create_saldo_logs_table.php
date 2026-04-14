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
            $table->enum('type', ['credit', 'debit']); // credit = masuk, debit = keluar
            $table->decimal('amount', 12, 2);
            $table->decimal('saldo_before', 12, 2);
            $table->decimal('saldo_after', 12, 2);
            $table->string('description')->nullable();
            $table->string('reference_type')->nullable(); // 'order' / 'withdrawal'
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saldo_logs');
    }
};
