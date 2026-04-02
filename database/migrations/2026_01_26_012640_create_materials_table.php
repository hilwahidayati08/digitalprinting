    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
    public function up()
    {
        // Jika belum ada tabelnya
    Schema::create('materials', function (Blueprint $table) {
        $table->id('material_id');

        $table->string('material_name');
        $table->enum('material_type', [
            'roll', 
            'sheet', 
            'pcs'
        ]);
        // ukuran media (penting untuk stiker & banner)
        $table->decimal('width_cm', 10, 2)->nullable();
        $table->decimal('height_cm', 10, 2)->nullable();
        $table->decimal('spacing_mm',5,2)->default(0);

        // stok dalam unit (lembar / meter)
        $table->decimal('stock_qty', 10, 2)->default(0);

        $table->foreignId('unit_id')
            ->constrained('units', 'unit_id')
            ->onDelete('cascade');

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
