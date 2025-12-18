<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up(): void
  {
    // ===== contratos =====
    Schema::table('contratos', function (Blueprint $table) {
      $table->index('subasta_id');
    });

    // ===== lotes =====
    Schema::table('lotes', function (Blueprint $table) {
      $table->index(['estado', 'deleted_at']);
      $table->index('ultimo_contrato');
    });

    // ===== contrato_lotes =====
    Schema::table('contrato_lotes', function (Blueprint $table) {
      $table->index(['lote_id', 'estado']);
      $table->index('contrato_id');
      $table->index(['contrato_id', 'estado', 'lote_id']);
    });
  }

  public function down(): void
  {
    Schema::table('contratos', function (Blueprint $table) {
      $table->dropIndex(['subasta_id']);
    });

    Schema::table('lotes', function (Blueprint $table) {
      $table->dropIndex(['estado', 'deleted_at']);
      $table->dropIndex(['ultimo_contrato']);
    });

    Schema::table('contrato_lotes', function (Blueprint $table) {
      $table->dropIndex(['lote_id', 'estado']);
      $table->dropIndex(['contrato_id']);
      $table->dropIndex(['contrato_id', 'estado', 'lote_id']);
    });
  }
};
