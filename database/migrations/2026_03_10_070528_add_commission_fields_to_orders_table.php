<?php	

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Potongan harga karena member
            $table->decimal('discount_member', 12, 2)->default(0)->after('total');
            // Komisi yang didapat dari order ini (masuk ke saldo setelah paid)
            $table->decimal('commission_earned', 12, 2)->default(0)->after('discount_member');
            // Saldo komisi yang dipakai untuk bayar order ini
            $table->decimal('komisi_digunakan', 12, 2)->default(0)->after('commission_earned');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['discount_member', 'commission_earned', 'komisi_digunakan']);
        });
    }
};
