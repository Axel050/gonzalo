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
    Schema::table('adquirentes', function (Blueprint $table) {

      // Make condicion_iva_id nullable
      $table->foreignId('condicion_iva_id')->nullable()->change();

      // Make CUIT nullable and remove unique constraint
      $table->string('CUIT')->nullable()->change();
      $table->string('domicilio')->nullable()->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('adquirentes', function (Blueprint $table) {
      // Revert condicion_iva_id to not nullable
      $table->foreignId('condicion_iva_id')->constrained('condicion_ivas')->onDelete('cascade')->change();

      // Revert CUIT to not nullable and add unique constraint
      $table->string('CUIT')->unique()->change();
      $table->string('domicilio')->required()->change();
    });
  }
};
