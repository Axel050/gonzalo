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
              $table->string('alias')->unique();
              $table->foreignId('estado_id')->constrained('estados_adquirentes')->onDelete('cascade');
              $table->string('CUIT')->unique();           
              $table->foreignId('condicion_iva_id')->constrained('condicion_ivas')->onDelete('cascade');
              $table->string('domicilio');
              $table->string('foto')->nullable();
              $table->string('telefono')->unique();              
              $table->decimal('comision', 5, 1)->default(20);
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
        Schema::dropIfExists('adquirentes');
    }
};
