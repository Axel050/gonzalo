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
    Schema::table('factura_lotes', function (Blueprint $table) {
      if (!Schema::hasColumn('factura_lotes', 'concepto')) {
        $table->string('concepto')->nullable(); // Descripción del ítem
      }
      // Para cambiar una columna existente, mejor asegurarse que existe
      if (Schema::hasColumn('factura_lotes', 'precio')) {
        $table->decimal('precio', 15, 2)->nullable()->change(); // Aumentar precisión
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('factura_lotes', function (Blueprint $table) {
      $table->dropColumn('concepto');
      $table->decimal('precio', 10, 2)->nullable()->change();
    });
  }
};
