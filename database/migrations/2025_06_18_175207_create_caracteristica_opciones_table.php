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
    Schema::create('caracteristica_opciones', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('caracteristica_id');
      $table->string('valor');
      $table->foreign('caracteristica_id')->references('id')->on('caracteristicas')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('caracteristica_opciones');
  }
};
