<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  // PARA VENTAS DIRECTAS SE PODRIA PONER COMO ESTADO 
  public function up(): void
  {

    Schema::create('lotes', function (Blueprint $table) {
      $table->id();
      // $table->integer("numero")->nullable();
      $table->string('titulo');
      $table->text('descripcion')->nullable();
      // $table->decimal('precio_base', 10, 2)->nullable(); 
      $table->decimal('valuacion', 10, 2)->nullable();
      $table->string('foto1')->nullable();
      $table->string('foto2')->nullable();
      $table->string('foto3')->nullable();
      $table->string('foto4')->nullable();
      $table->integer('fraccion_min')->nullable();

      $table->boolean('venta_directa')->default(false);
      $table->decimal('precio_venta_directa', 10, 2)->nullable();

      $table->unsignedBigInteger('tipo_bien_id')->nullable();

      $table->foreignId('comitente_id')->constrained('comitentes')->onDelete('cascade');
      $table->string('estado')->default('disponible');

      $table->foreignId('ultimo_contrato')->nullable()->constrained('contratos')->onDelete('set null');
      $table->foreign('tipo_bien_id')->references('id')->on('tipos_biens')->onDelete('cascade');
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('lotes');
  }
};
