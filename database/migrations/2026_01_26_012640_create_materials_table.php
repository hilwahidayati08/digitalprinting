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
        Schema::create('materials', function (Blueprint $table) {
            $table->id('material_id');
 
            $table->string('material_name');
            $table->enum('material_type', ['roll', 'sheet', 'pcs']);
 
            // Ukuran media (penting untuk stiker & banner)
            $table->decimal('width_cm', 10, 2)->nullable();
            $table->decimal('height_cm', 10, 2)->nullable();
            $table->decimal('spacing_mm', 5, 2)->default(0);
 
            // Stok
            $table->decimal('stock', 10, 2)->default(0);
            $table->decimal('min_stock', 10, 2)->default(10.00);
            $table->string('stock_unit')->default('m²');
 
            $table->foreignId('unit_id')->constrained('units', 'unit_id')->onDelete('cascade');
 
            $table->timestamps();
        });
    }
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('materials');
        }
    };
