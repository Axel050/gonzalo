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
    Schema::create('orden_lotes', function (Blueprint $table) {
      $table->id();
      $table->foreignId('orden_id')->constrained('ordens')->onDelete('cascade');
      $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');
      $table->integer('precio_final')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orden_lotes');
  }
};
