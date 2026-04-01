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
        Schema::table('liquidacions', function (Blueprint $table) {
            $table->text('observaciones')->nullable();
            $table->decimal('monto_total', 15, 2)->default(0);
            $table->decimal('subtotal_lotes', 15, 2)->default(0);
            $table->decimal('subtotal_comisiones', 15, 2)->default(0);
            $table->decimal('subtotal_gastos', 15, 2)->default(0);
            $table->decimal('comision_porcentaje', 5, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('liquidacions', function (Blueprint $table) {
            $table->dropColumn([
                'observaciones',
                'monto_total',
                'subtotal_lotes',
                'subtotal_comisiones',
                'subtotal_gastos',
                'comision_porcentaje'
            ]);
        });
    }
};
