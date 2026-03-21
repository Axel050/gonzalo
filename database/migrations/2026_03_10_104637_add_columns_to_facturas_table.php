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
    Schema::table('facturas', function (Blueprint $table) {
      // Modificar numero para que sea nullable
      $table->integer("numero")->nullable()->change();

      // Nuevos campos para facturación y AFIP
      $table->string('tipo_comprobante')->nullable(); // A, B, C, Nota de Crédito A, etc.
      $table->string('tipo_concepto')->nullable(); // Comisión, Garantía, Envío, Venta Lote
      $table->integer('punto_venta')->nullable();
      $table->string('cae')->nullable();
      $table->date('vto_cae')->nullable();
      $table->decimal('monto_total', 15, 2)->default(0);
      $table->foreignId('orden_id')->nullable()->after('adquirente_id')->constrained('ordens')->onDelete('set null');

      // Relación con otra factura
      $table->foreignId('factura_asociada_id')->nullable()->constrained('facturas')->onDelete('set null');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('facturas', function (Blueprint $table) {
      $table->integer("numero")->nullable(false)->change();
      $table->dropForeign(['orden_id']);
      $table->dropColumn([
        'tipo_comprobante',
        'tipo_concepto',
        'punto_venta',
        'cae',
        'vto_cae',
        'monto_total',
        'factura_asociada_id',
        'orden_id'
      ]);
    });
  }
};
