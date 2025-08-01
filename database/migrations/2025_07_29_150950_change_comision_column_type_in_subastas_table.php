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
      $table->integer('comision')->default(20)->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('subastas', function (Blueprint $table) {
      $table->decimal('comision', 5, 2)->default(20)->change();
    });
  }
};
