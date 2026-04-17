<?php

namespace App\Services;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Liquidacion;
use App\Models\LiquidacionLote;
use App\Models\Lote;
use Exception;
use Illuminate\Support\Facades\DB;

class LiquidacionService
{
    public function crearLiquidacion(Comitente $comitente, array $items, $comision_porcentaje, $observaciones = null)
    {
        DB::beginTransaction();

        try {
            $items_ingreso = array_filter($items, fn ($i) => $i['tipo'] == 'ingreso');
            $items_egreso = array_filter($items, fn ($i) => $i['tipo'] != 'ingreso');

            $liq_ingreso = null;
            $liq_egreso = null;

            // 1. LIQUIDACIÓN DE MARTILLO (Ingresos)
            if (count($items_ingreso) > 0) {
                $ultimoNum = Liquidacion::max('numero') ?? 0;
                $numero = $ultimoNum + 1;

                $subtotal_lotes = 0;
                foreach ($items_ingreso as $item) {
                    $subtotal_lotes += $item['monto'];
                }

                $liq_ingreso = Liquidacion::create([
                    'numero' => $numero,
                    'fecha' => now(),
                    'estado' => 'generada',
                    'comitente_id' => $comitente->id,
                    'observaciones' => $observaciones,
                    'monto_total' => $subtotal_lotes,
                    'subtotal_lotes' => $subtotal_lotes,
                    'subtotal_comisiones' => 0,
                    'subtotal_gastos' => 0,
                    'comision_porcentaje' => 0,
                    'tipo_concepto' => 'martillo',
                    'liquidacion_asociada_id' => null,
                ]);

                foreach ($items_ingreso as $item) {
                    LiquidacionLote::create([
                        'liquidacion_id' => $liq_ingreso->id,
                        'lote_id' => $item['lote_id'] ?? null,
                        'subasta_id' => $item['subasta_id'] ?? null,
                        'tipo' => $item['tipo'],
                        'concepto' => $item['concepto'],
                        'monto' => $item['monto'],
                    ]);

                    if (! empty($item['lote_id'])) {
                        $lote = Lote::find($item['lote_id']);
                        if ($lote) {
                            $lote->estado = LotesEstados::LIQUIDADO;
                            $lote->save();
                        }
                    }
                }
            }

            // 2. LIQUIDACIÓN DE GASTOS Y COMISIONES (Egresos)
            if (count($items_egreso) > 0) {
                $ultimoNum = Liquidacion::max('numero') ?? 0;
                $numero = $ultimoNum + 1;

                $subtotal_comisiones = 0;
                $subtotal_gastos = 0;

                foreach ($items_egreso as $item) {
                    if ($item['tipo'] == 'egreso_comision') {
                        $subtotal_comisiones += $item['monto'];
                    } else {
                        $subtotal_gastos += $item['monto'];
                    }
                }

                $liq_egreso = Liquidacion::create([
                    'numero' => $numero,
                    'fecha' => now(),
                    'estado' => 'generada',
                    'comitente_id' => $comitente->id,
                    'observaciones' => $observaciones,
                    'monto_total' => $subtotal_comisiones + $subtotal_gastos,
                    'subtotal_lotes' => 0,
                    'subtotal_comisiones' => $subtotal_comisiones,
                    'subtotal_gastos' => $subtotal_gastos,
                    'comision_porcentaje' => $comision_porcentaje,
                    'tipo_concepto' => 'servicios',
                    'liquidacion_asociada_id' => $liq_ingreso ? $liq_ingreso->id : null,
                ]);

                foreach ($items_egreso as $item) {
                    LiquidacionLote::create([
                        'liquidacion_id' => $liq_egreso->id,
                        'lote_id' => $item['lote_id'] ?? null,
                        'subasta_id' => $item['subasta_id'] ?? null,
                        'tipo' => $item['tipo'],
                        'concepto' => $item['concepto'],
                        'monto' => $item['monto'],
                    ]);
                }
            }

            DB::commit();

            return $liq_ingreso ?? $liq_egreso;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function anularLiquidacion(int $liquidacionId): bool
    {
        return DB::transaction(function () use ($liquidacionId) {
            $liquidacion = Liquidacion::with(['asociadas', 'items'])->lockForUpdate()->findOrFail($liquidacionId);

            if ($liquidacion->estado === 'anulada') {
                return false;
            }

            // Anular la principal
            $liquidacion->estado = 'anulada';
            $liquidacion->save();

            // Anular asociadas
            foreach ($liquidacion->asociadas as $asociada) {
                $asociada->estado = 'anulada';
                $asociada->save();
            }

            // Revertir estado de los lotes
            $lotesIds = $liquidacion->items->pluck('lote_id')->filter()->unique();

            foreach ($liquidacion->asociadas as $asociada) {
                $lotesIds = $lotesIds->merge($asociada->items->pluck('lote_id')->filter());
            }

            $lotesIds = $lotesIds->unique();

            if ($lotesIds->isNotEmpty()) {
                Lote::whereIn('id', $lotesIds)->update(['estado' => LotesEstados::FACTURADO]);
            }

            return true;
        });
    }
}
