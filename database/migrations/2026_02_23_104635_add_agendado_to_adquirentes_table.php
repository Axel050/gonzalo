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
      $table->boolean('agendado')->default(false)->after('domicilio_envio');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('adquirentes', function (Blueprint $table) {
      $table->dropColumn('agendado');
    });
  }
};
