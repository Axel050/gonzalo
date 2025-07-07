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
    Schema::table('contrato_lotes', function (Blueprint $table) {
      $table->string('estado')->default('activo'); // Estados: activo, inactivo, adjudicado
      $table->timestamp('tiempo_post_subasta_fin')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('contrato_lotes', function (Blueprint $table) {
      $table->dropColumn('estado');
      $table->dropColumn('tiempo_post_subasta_fin');
    });
  }
};
