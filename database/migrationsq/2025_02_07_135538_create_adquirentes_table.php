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
    Schema::create('adquirentes', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->string('apellido');
      $table->unsignedBigInteger('alias_id')->nullable();
      $table->foreignId('estado_id')->constrained('estados_adquirentes')->onDelete('cascade');
      $table->string('CUIT')->nullable();
      $table->foreignId('condicion_iva_id')->nullable()->constrained('condicion_ivas')->onDelete('cascade');

      $table->string('domicilio')->nullable();
      $table->string('foto')->nullable();
      $table->string('telefono');
      $table->integer('comision')->default(20);

      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('CBU')->nullable();
      $table->string('banco')->nullable();
      $table->string('numero_cuenta')->nullable();
      $table->string('alias_bancario')->nullable();




      // Make CUIT nullable and remove unique constraint



      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('adquirentes');
  }
};
