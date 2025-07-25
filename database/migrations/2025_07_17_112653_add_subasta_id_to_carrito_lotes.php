<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubastaIdToCarritoLotes extends Migration
{
  public function up(): void
  {
    Schema::table('carrito_lotes', function (Blueprint $table) {
      $table->foreignId('subasta_id')->constrained('subastas')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::table('carrito_lotes', function (Blueprint $table) {
      $table->dropForeign(['subasta_id']);
      $table->dropColumn('subasta_id');
    });
  }
}
