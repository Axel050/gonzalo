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
      $table->integer('comision')->default(20)->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('adquirentes', function (Blueprint $table) {
      $table->decimal('comision', 5, 1)->default(20);
    });
  }
};
