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
      $table->integer('precio_base')->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('contrato_lotes', function (Blueprint $table) {
      $table->decimal('precio_base', 10, 2);
    });
  }
};
