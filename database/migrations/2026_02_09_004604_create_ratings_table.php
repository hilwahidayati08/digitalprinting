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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('rating_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('product_id')->constrained('products', 'product_id');
            $table->unsignedBigInteger('order_id')->nullable();
 
            $table->foreign('order_id')
                  ->references('order_id')
                  ->on('orders')
                  ->onDelete('set null');
 
            $table->tinyInteger('rating');
            $table->text('review')->nullable();
 
            // 1 user hanya bisa rating 1x per order + product
            $table->unique(['user_id', 'product_id', 'order_id'], 'ratings_user_product_order_unique');
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
