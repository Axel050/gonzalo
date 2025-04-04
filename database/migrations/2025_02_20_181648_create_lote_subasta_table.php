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
        Schema::create('lote_subastas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade'); // Relación con lotes
            $table->foreignId('subasta_id')->constrained('subastas')->onDelete('cascade'); // Relación con subastas
            $table->foreignId('contrato_id')->constrained()->onDelete('cascade');
            $table->decimal('precio_base', 10, 2); // Precio base en el momento de la subasta
            
            $table->foreignId('adquirente_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('precio_final', 10, 2)->nullable(); // Precio final (si se vendió)
            $table->string('estado')->default('pendiente'); // Estado del lote en la subasta (pendiente, activo, vendido, no_vendido)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lote_subasta');
    }
};
