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
      $table->foreign('alias_id')
        ->references('id')
        ->on('adquirentes_aliases')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('adquirentes', function (Blueprint $table) {
      //
    });
  }
};
