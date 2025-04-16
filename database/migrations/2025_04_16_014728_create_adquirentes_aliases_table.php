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
    Schema::create('adquirentes_aliases', function (Blueprint $table) {
      $table->id();
      $table->string('nombre')->unique();
      $table->foreignId('adquirente_id')->constrained('adquirentes')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('adquirentes_aliases');
  }
};
