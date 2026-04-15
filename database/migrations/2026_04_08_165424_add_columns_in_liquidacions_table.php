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
            $table->foreignId('liquidacion_asociada_id')->nullable()->constrained('liquidacions')->onDelete('set null');
            $table->string('tipo_concepto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('liquidacions', function (Blueprint $table) {
            $table->dropForeign(['liquidacion_asociada_id']);
            $table->dropColumn(['liquidacion_asociada_id', 'tipo_concepto']);
        });
    }
};
