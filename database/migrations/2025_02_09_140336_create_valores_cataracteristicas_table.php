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
    Schema::create('valores_cataracteristicas', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('lote_id');
      $table->unsignedBigInteger('caracteristica_id');
      $table->text('valor')->nullable();
      $table->foreign('lote_id')->references('id')->on('lotes')->onDelete('cascade');
      $table->foreign('caracteristica_id')->references('id')->on('caracteristicas')->onDelete('cascade');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('valores_cataracteristicas');
  }
};
