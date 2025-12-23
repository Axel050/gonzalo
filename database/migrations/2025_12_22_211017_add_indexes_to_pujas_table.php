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
    Schema::table('pujas', function (Blueprint $table) {
      // para where lote_id = ? order by id desc
      $table->index(['lote_id', 'id']);

      // opcional (si usás filtros por usuario en el futuro)
      // $table->index(['user_id', 'lote_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('pujas', function (Blueprint $table) {
      $table->dropIndex(['lote_id', 'id']);
      // $table->dropIndex(['user_id', 'lote_id']);
    });
  }
};
