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
    Schema::table('ordens', function (Blueprint $table) {
      $table->timestamp('facturas_generadas_at')->nullable()->after('fecha_pago');
      $table->timestamp('liquidaciones_generadas_at')->nullable()->after('fecha_pago');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('ordens', function (Blueprint $table) {
      $table->dropColumn('facturas_generadas_at');
      $table->dropColumn('liquidaciones_generadas_at');
    });
  }
};
