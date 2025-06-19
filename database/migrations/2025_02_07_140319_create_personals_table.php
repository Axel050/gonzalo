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
    Schema::create('personals', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->string('apellido');
      $table->string('alias')->nullable()->unique();
      $table->string('CUIT')->nullable()->unique();
      $table->string('domicilio')->nullable();
      $table->string('telefono')->unique();
      $table->string('foto')->nullable();

      // $table->unsignedBigInteger('departamento_id');
      // $table->foreign('departamento_id')->references('id')->on('departamento_personals')->onDelete('cascade');

      // $table->foreignId('comitente_id')->constrained('comitentes')->onDelete('cascade');            
      $table->foreignId('role_id')->constrained()->onDelete('cascade');

      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->softDeletes();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('personals');
  }
};
