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
        Schema::create('comitentes', function (Blueprint $table) {
            $table->id();              
            $table->string('nombre');
            $table->string('apellido');
            $table->string('alias')->nullable()->unique();
            $table->string('CUIT')->unique();
            $table->string('domicilio');
            $table->string('telefono')->unique();
            $table->string('mail')->unique();
            $table->string('foto')->nullable();
            $table->decimal('comision', 5, 1)->default(20); 
            $table->string('banco')->nullable();
            $table->string('numero_cuenta')->nullable();
            $table->string('CBU')->nullable();
            $table->string('alias_bancario')->nullable();
            $table->text('observaciones')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comitentes');
    }
};
