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
    Schema::table('materials', function (Blueprint $table) {
        // Tambahkan kolom min_stock setelah kolom stock
        // Default 10 artinya jika tidak diisi, batas peringatannya adalah 10
        $table->decimal('min_stock', 10, 2)->default(10.00)->after('stock');
    });
}

public function down(): void
{
    Schema::table('materials', function (Blueprint $table) {
        $table->dropColumn('min_stock');
    });
}
};
