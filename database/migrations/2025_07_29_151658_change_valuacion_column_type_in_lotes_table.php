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
    Schema::table('lotes', function (Blueprint $table) {
      $table->integer('valuacion')->nullable()->change();
      $table->integer('precio_venta_directa')->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('lotes', function (Blueprint $table) {
      $table->decimal('valuacion', 5, 2)->default(20)->change();
      $table->decimal('precio_venta_directa', 10, 2)->nullable();
    });
  }
};
