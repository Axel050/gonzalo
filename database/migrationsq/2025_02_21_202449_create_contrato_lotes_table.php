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
    Schema::create('contrato_lotes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('contrato_id')->constrained()->onDelete('cascade');
      $table->foreignId('lote_id')->constrained()->onDelete('cascade');
      $table->integer('precio_base');
      $table->unsignedBigInteger('moneda_id')->nullable();


      // Índice único para evitar duplicados
      $table->unique(['contrato_id', 'lote_id']);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('contrato_lotes');
  }
};
