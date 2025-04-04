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

        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->integer("numero")->unique();
            $table->date('fecha');
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('cuit')->nullable();
            $table->string('dni')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->string('tipo')->nullable();
            $table->string('estado')->nullable();
            $table->string('condicion_iva')->nullable();
            $table->string('comision_subasta')->nullable();            
            $table->string('iva_subasta')->nullable();
            $table->string('observaciones')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('estado_pago')->nullable();

            
            $table->softDeletes();
            $table->foreignId('adquirente_id')->constrained('adquirentes')->onDelete('cascade');  
            // $table->foreignId('subasta_id')->constrained('subastas')->onDelete('cascade');  
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
