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
    Schema::create('subastas', function (Blueprint $table) {
      $table->id();
      // $table->integer('numero_subasta')->unique();
      $table->string('titulo', 255);
      $table->string('descripcion', 255)->nullable();
      $table->integer('comision')->default(20);
      $table->dateTime('fecha_inicio')->nullable();
      $table->dateTime('fecha_fin')->nullable();
      $table->integer('tiempo_post_subasta');
      $table->string('estado')->default("inactiva");
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('subastas');
  }
};
