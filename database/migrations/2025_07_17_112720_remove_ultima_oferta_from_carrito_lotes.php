<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUltimaOfertaFromCarritoLotes extends Migration
{
  public function up(): void
  {
    Schema::table('carrito_lotes', function (Blueprint $table) {
      $table->dropColumn('ultima_oferta');
    });
  }

  public function down(): void
  {
    Schema::table('carrito_lotes', function (Blueprint $table) {
      $table->decimal('ultima_oferta', 10, 2)->nullable();
    });
  }
}
