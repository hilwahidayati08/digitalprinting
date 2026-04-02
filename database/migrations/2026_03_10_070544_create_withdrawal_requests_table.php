<?php	

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id('withdrawal_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');

            $table->decimal('amount', 12, 2);       // Jumlah yang diminta
            $table->string('bank_name');             // Nama bank
            $table->string('account_number');        // Nomor rekening
            $table->string('account_name');          // Nama pemilik rekening

            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};
