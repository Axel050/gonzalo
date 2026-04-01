<?php

namespace App\Services;

use App\Models\Comitente;
use App\Models\Liquidacion;
use App\Models\LiquidacionLote;
use App\Models\Lote;
use App\Enums\LotesEstados;
use Illuminate\Support\Facades\DB;
use Exception;

class LiquidacionService
{
  public function crearLiquidacion(Comitente $comitente, array $items, $comision_porcentaje, $observaciones = null)
  {
    DB::beginTransaction();

    try {
      $subtotal_lotes = 0;
      $subtotal_comisiones = 0;
      $subtotal_gastos = 0;

      // Calcular totales
      foreach ($items as $item) {
        if ($item['tipo'] == 'ingreso') {
          $subtotal_lotes += $item['monto'];
        } elseif ($item['tipo'] == 'egreso_comision') {
          $subtotal_comisiones += $item['monto'];
        } elseif ($item['tipo'] == 'egreso_gasto') {
          $subtotal_gastos += $item['monto'];
        }
      }

      $monto_total = $subtotal_lotes - $subtotal_comisiones - $subtotal_gastos;

      // Siguiente numero
      $ultimoNum = Liquidacion::max('numero') ?? 0;
      $numero = $ultimoNum + 1;

      $liquidacion = Liquidacion::create([
        'numero' => $numero,
        'fecha' => now(),
        'estado' => 'generada',
        'comitente_id' => $comitente->id,
        'observaciones' => $observaciones,
        'monto_total' => $monto_total,
        'subtotal_lotes' => $subtotal_lotes,
        'subtotal_comisiones' => $subtotal_comisiones,
        'subtotal_gastos' => $subtotal_gastos,
        'comision_porcentaje' => $comision_porcentaje,
      ]);

      foreach ($items as $item) {
        LiquidacionLote::create([
          'liquidacion_id' => $liquidacion->id,
          'lote_id' => $item['lote_id'] ?? null,
          'subasta_id' => $item['subasta_id'] ?? null,
          'tipo' => $item['tipo'],
          'concepto' => $item['concepto'],
          'monto' => $item['monto'],
        ]);

        if (!empty($item['lote_id']) && $item['tipo'] == 'ingreso') {
            $lote = Lote::find($item['lote_id']);
            if($lote){
                $lote->estado = LotesEstados::LIQUIDADO;
                $lote->save();
            }
        }
      }

      DB::commit();

      return $liquidacion;
    } catch (Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }
}
