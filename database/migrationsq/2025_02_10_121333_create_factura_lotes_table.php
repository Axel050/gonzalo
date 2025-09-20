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
        Schema::create('factura_lotes', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio', 10, 2)->nullable(); 
            $table->foreignId('factura_id')->constrained('facturas')->onDelete('cascade');  
            $table->foreignId('lote_id')->constrained('lotes')->onDelete('cascade');  
            $table->foreignId('subasta_id')->constrained('subastas')->onDelete('cascade');  
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factura_lotes');
    }
};
