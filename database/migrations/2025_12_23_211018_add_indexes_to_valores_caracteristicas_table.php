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
    Schema::table('valores_cataracteristicas', function (Blueprint $table) {

      $table->index('lote_id');
      $table->index('valor');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('valores_cataracteristicas', function (Blueprint $table) {
      $table->dropIndex('lote_id');
      $table->dropIndex('valor');
    });
  }
};
