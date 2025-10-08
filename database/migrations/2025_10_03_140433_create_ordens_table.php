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
    Schema::create('ordens', function (Blueprint $table) {
      $table->id();
      $table->foreignId('adquirente_id')->constrained()->onDelete('cascade');
      $table->foreignId('subasta_id')->constrained("subastas")->onDelete('cascade');
      $table->integer('total')->default(0);
      $table->integer('descuento')->default(0);
      $table->enum('estado', ['pendiente', 'pagada', 'cancelada'])->default('pendiente');
      $table->string('payment_id')->nullable();
      $table->date('fecha_pago')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ordens');
  }
};
