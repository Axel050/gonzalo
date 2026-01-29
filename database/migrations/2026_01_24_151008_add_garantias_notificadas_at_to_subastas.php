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
    Schema::table('subastas', function (Blueprint $table) {
      $table->timestamp('garantias_notificadas_at')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('subastas', function (Blueprint $table) {
      $table->dropColumn('garantias_notificadas_at');
    });
  }
};
