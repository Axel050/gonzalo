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
    Schema::create('depositos', function (Blueprint $table) {
      $table->id();
      $table->date('fecha')->nullable();
      $table->integer('monto')->nullable();

      $table->string('estado')->nullable();
      $table->date('fecha_devolucion')->nullable();


      $table->foreignId('adquirente_id')->constrained('adquirentes')->onDelete('cascade');
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
    Schema::dropIfExists('depositos');
  }
};
