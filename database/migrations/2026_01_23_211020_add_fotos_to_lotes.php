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
      $table->text('foto5')->nullable()->default(null);
      $table->text('foto6')->nullable()->default(null);
      $table->text('foto7')->nullable()->default(null);
      $table->text('foto8')->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('lotes', function (Blueprint $table) {
      $table->dropColumn('foto5');
      $table->dropColumn('foto6');
      $table->dropColumn('foto7');
      $table->dropColumn('foto8');
    });
  }
};
