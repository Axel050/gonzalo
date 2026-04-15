<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devolucion_lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devolucion_id')->constrained('devolucions')->onDelete('cascade');
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['devolucion_id', 'lote_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devolucion_lotes');
    }
};
