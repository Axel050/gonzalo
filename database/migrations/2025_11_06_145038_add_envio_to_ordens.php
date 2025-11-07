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
      $table->integer('monto_envio')->default(0);
      $table->boolean('envio_check')->default(false);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('ordens', function (Blueprint $table) {
      $table->dropColumn('monto_envio');
      $table->dropColumn('envio_check');
    });
  }
};
