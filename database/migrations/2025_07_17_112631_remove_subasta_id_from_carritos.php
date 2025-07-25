<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSubastaIdFromCarritos extends Migration
{
  public function up(): void
  {
    Schema::table('carritos', function (Blueprint $table) {
      $table->dropForeign(['subasta_id']);
      $table->dropColumn('subasta_id');
    });
  }

  public function down(): void
  {
    Schema::table('carritos', function (Blueprint $table) {
      $table->foreignId('subasta_id')->constrained('subastas')->onDelete('cascade');
    });
  }
}
