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
        Schema::table('liquidacion_lotes', function (Blueprint $table) {
            $table->unsignedBigInteger('lote_id')->nullable()->change();
            $table->unsignedBigInteger('subasta_id')->nullable()->change();
            
            $table->string('tipo')->default('ingreso'); // 'ingreso', 'egreso_comision', 'egreso_gasto'
            $table->string('concepto')->nullable();
            $table->decimal('monto', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('liquidacion_lotes', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'concepto', 'monto']);
            
            // Reverting nullable is tricky sometimes, so we'll just leave them nullable or force them back
            $table->unsignedBigInteger('lote_id')->nullable(false)->change();
            $table->unsignedBigInteger('subasta_id')->nullable(false)->change();
        });
    }
};
