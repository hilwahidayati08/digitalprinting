<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('product_id');

            $table->foreign('order_id')
                  ->references('order_id')
                  ->on('orders')
                  ->onDelete('set null');

            // Hapus unique constraint lama jika ada (user+product)
            // Sesuaikan nama constraint dengan yang ada di DB kamu
            // $table->dropUnique(['user_id', 'product_id']);

            // Tambah unique constraint baru: 1 user hanya bisa rating 1x per order+product
            $table->unique(['user_id', 'product_id', 'order_id'], 'ratings_user_product_order_unique');
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropUnique('ratings_user_product_order_unique');
            $table->dropColumn('order_id');
        });
    }
};