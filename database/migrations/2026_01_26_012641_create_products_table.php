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
        // ─── PRODUCTS ─────────────────────────────────────────────
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('category_id')->constrained('categories', 'category_id');
            $table->foreignId('material_id')->constrained('materials', 'material_id');
            $table->foreignId('unit_id')->constrained('units', 'unit_id');
 
            $table->string('product_name', 100);
            $table->string('slug')->unique();
            $table->text('description')->nullable();
 
            /*
            Price logic:
              satuan → per pcs
              luas   → per m²
              stiker → per lembar media
            */
            $table->decimal('price', 15, 2);
            $table->integer('production_time')->default(1); // dalam hari
 
            $table->boolean('allow_custom_size')->default(false);
            $table->decimal('default_width_cm', 10, 2)->nullable();
            $table->decimal('default_height_cm', 10, 2)->nullable();
 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
