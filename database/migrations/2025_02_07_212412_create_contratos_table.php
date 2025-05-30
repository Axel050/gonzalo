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
    Schema::create('contratos', function (Blueprint $table) {
      $table->id();

      $table->string('archivo_path')->nullable();
      $table->string('descripcion')->nullable();
      $table->date('fecha_firma')->nullable();
      $table->foreignId('comitente_id')->constrained('comitentes')->onDelete('cascade');
      $table->foreignId('subasta_id')->constrained('subastas')->onDelete('cascade');

      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('contratos');
  }
};
