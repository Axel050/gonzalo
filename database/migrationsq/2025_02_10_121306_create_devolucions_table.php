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
        Schema::create('devolucions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motivo_id')->constrained('motivo_devolucions')->onDelete('cascade');  
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');              
            $table->date('fecha');
            $table->string('descripcion')->nullable();
            $table->string('estado')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucions');
    }
};
