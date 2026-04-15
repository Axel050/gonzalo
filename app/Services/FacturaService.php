<?php

namespace App\Services;

use App\Models\Adquirente;
use App\Models\Factura;
use App\Models\FacturaLote;
use App\Models\Lote;
use App\Models\Orden;
use App\Enums\LotesEstados;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FacturaService
{
    protected $afipService;

    public function __construct(AfipService $afipService)
    {
        $this->afipService = $afipService;
    }

    /**
     * Crea una factura electrónica de comisión para el adquirente.
     */
    public function crearFacturaComision(Adquirente $adquirente, $items, $total, $observaciones = null)
    {
        return $this->crearFactura($adquirente, 'comision', 'A', $items, $total, $observaciones);
    }

    /**
     * Crea una factura electrónica de garantía.
     */
    public function crearFacturaGarantia(Adquirente $adquirente, $monto, $observaciones = null)
    {
        $items = [
            [
                'concepto' => 'Garantía de oferta',
                'precio' => $monto,
                'lote_id' => null,
                'subasta_id' => null,
            ],
        ];

        return $this->crearFactura($adquirente, 'garantia', 'A', $items, $monto, $observaciones);
    }

    /**
     * Crea una factura electrónica por envío.
     */
    public function crearFacturaEnvio(Adquirente $adquirente, $monto, $observaciones = null)
    {
        $items = [
            [
                'concepto' => 'Servicio de Envío',
                'precio' => $monto,
                'lote_id' => null,
                'subasta_id' => null,
            ],
        ];

        return $this->crearFactura($adquirente, 'envio', 'A', $items, $monto, $observaciones);
    }

    public function generarFacturasAgrupadas(array $ordenesIds)
    {
        DB::beginTransaction();

        try {

            $ordenes = \App\Models\Orden::with(['lotes.lote', 'adquirente', 'subasta'])
                ->whereIn('id', $ordenesIds)
                ->get();

            if ($ordenes->isEmpty()) {
                throw new Exception('No hay órdenes seleccionadas.');
            }

            // ✅ mismo adquirente
            $adquirente = $ordenes->first()->adquirente;

            foreach ($ordenes as $orden) {

                if ($orden->adquirente_id !== $adquirente->id) {
                    throw new Exception('Todas las órdenes deben ser del mismo adquirente.');
                }

                // ✅ evitar duplicadas
                if ($orden->facturas_generadas_at) {
                    throw new Exception("La orden #{$orden->id} ya fue facturada.");
                }
            }

            $itemsMartillo = [];
            $totalMartillo = 0;

            $itemsServicios = [];
            $totalServicios = 0;

            foreach ($ordenes as $orden) {

                /**
                 * =========================
                 * MARTILLO (LOTE)
                 * =========================
                 */
                foreach ($orden->lotes as $ordenLote) {

                    $lote = $ordenLote->lote;
                    if (! $lote) {
                        continue;
                    }

                    $precio = $ordenLote->precio_final;

                    $itemsMartillo[] = [
                        'concepto' => "Orden #{$orden->id} - Lote {$lote->id} ({$orden->subasta?->titulo})",
                        'precio' => $precio,
                        'lote_id' => $lote->id,
                        'subasta_id' => $orden->subasta->id ?? null,
                    ];

                    $totalMartillo += $precio;

                    // ✅ actualizar estado lote
                    $lote->estado = \App\Enums\LotesEstados::FACTURADO;
                    $lote->save();
                }

                /**
                 * =========================
                 * COMISION
                 * =========================
                 */
                $porcentaje = $orden->porcentaje_comision ?? 20;
                $porcentajeMostrar = intval($porcentaje);
                $baseOrden = $orden->lotes->sum('precio_final');
                $totalComision = $orden->monto_comision ?? ($baseOrden * $porcentaje / 100);

                if ($totalComision > 0) {
                    $itemsServicios[] = [
                        'concepto' => "Orden #{$orden->id} - Comisión {$porcentajeMostrar}% ({$orden->subasta?->titulo})",
                        'precio' => $totalComision,
                        'lote_id' => null,
                        'subasta_id' => $orden->subasta->id ?? null,
                    ];

                    $totalServicios += $totalComision;
                }

                /**
                 * =========================
                 * ENVIO
                 * =========================
                 */
                if ($orden->monto_envio > 0) {
                    $itemsServicios[] = [
                        'concepto' => "Orden #{$orden->id} - Envío ({$orden->subasta?->titulo})",
                        'precio' => $orden->monto_envio,
                        'lote_id' => null,
                        'subasta_id' => $orden->subasta->id ?? null,
                    ];

                    $totalServicios += $orden->monto_envio;
                }
            }

            /**
             * =========================
             * FACTURA MARTILLO
             * =========================
             */
            $facturaMartillo = null;

            if ($totalMartillo > 0) {

                $facturaMartillo = $this->crearFactura(
                    $adquirente,
                    'martillo',
                    'P',
                    $itemsMartillo,
                    $totalMartillo,
                    'Facturación múltiple órdenes: '.implode(',', $ordenesIds)
                );

                // ✅ relacionar órdenes
                $facturaMartillo->ordenes()->attach($ordenesIds);
            }

            /**
             * =========================
             * FACTURA SERVICIOS
             * =========================
             */
            $facturaServicios = null;

            if ($totalServicios > 0) {

                $facturaServicios = $this->crearFactura(
                    $adquirente,
                    'servicios',
                    'C',
                    $itemsServicios,
                    $totalServicios,
                    'Servicios múltiples órdenes: '.implode(',', $ordenesIds)
                );

                // ✅ relacionar órdenes
                $facturaServicios->ordenes()->attach($ordenesIds);

                // vincular facturas para mostrar total conjunto en listados
                if ($facturaMartillo && $facturaServicios) {
                    $facturaMartillo->factura_asociada_id = $facturaServicios->id;
                    $facturaServicios->factura_asociada_id = $facturaMartillo->id;
                    $facturaMartillo->save();
                    $facturaServicios->save();
                }
            }

            /**
             * =========================
             * MARCAR ORDENES COMO FACTURADAS
             * =========================
             */
            foreach ($ordenes as $orden) {
                $orden->facturas_generadas_at = now();
                $orden->save();
            }

            DB::commit();

            return [
                'martillo' => $facturaMartillo,
                'servicios' => $facturaServicios,
            ];
        } catch (Exception $e) {

            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Centraliza la autorización AFIP para ser llamada desde varios puntos.
     */
    public function autorizarEnAfip(Factura $factura)
    {
        try {
            $afipResult = $this->afipService->autorizarFactura($factura);
            if ($afipResult && $afipResult['cae']) {
                $factura->cae = $afipResult['cae'];
                $factura->vto_cae = $afipResult['vto_cae'];
                $factura->save();

                return true;
            }
        } catch (Exception $e) {
            Log::error("Error al autorizar AFIP factura {$factura->id}: ".$e->getMessage());
            throw $e;
        }

        return false;
    }

    private function crearFactura($adquirente, $tipoConcepto, $tipoComprobante, $items, $total, $observaciones = null)
    {
        $factura = Factura::create([
            'adquirente_id' => $adquirente->id,
            'fecha' => now(),
            'tipo_concepto' => $tipoConcepto,
            'tipo_comprobante' => $tipoComprobante,
            'monto_total' => $total,
            'estado' => 'generada',
            'nombre' => $adquirente->nombre,
            'apellido' => $adquirente->apellido,
            'cuit' => $adquirente->CUIT,
            'dni' => $adquirente->dni,
            'direccion' => $adquirente->domicilio,
            'email' => $adquirente->user->email ?? $adquirente->email,
            'condicion_iva' => $adquirente->condicion_iva_id,
            'observaciones' => $observaciones,
        ]);

        foreach ($items as $item) {

            FacturaLote::create([
                'factura_id' => $factura->id,
                'lote_id' => $item['lote_id'] ?? null,
                'subasta_id' => $item['subasta_id'] ?? null,
                'concepto' => $item['concepto'],
                'precio' => $item['precio'],
            ]);
        }

        return $factura;
    }

    public function anularFactura(int $facturaId): bool
    {
        return DB::transaction(function () use ($facturaId) {
            $factura = Factura::with(['items', 'ordenes', 'facturaAsociada'])->lockForUpdate()->findOrFail($facturaId);

            if ($factura->estado === 'anulada') {
                return false;
            }

            // 1. Marcar factura como anulada
            $factura->estado = 'anulada';
            $factura->save();

            // 2. Si tiene una factura asociada, anularla también (evitar recursión infinita con un check)
            if ($factura->facturaAsociada && $factura->facturaAsociada->estado !== 'anulada') {
                $this->anularFactura($factura->facturaAsociada->id);
            }

            // 3. Revertir estado de los lotes a PAGADO
            $lotesIds = $factura->items->pluck('lote_id')->filter()->unique();
            if ($lotesIds->isNotEmpty()) {
                Lote::whereIn('id', $lotesIds)->update(['estado' => LotesEstados::PAGADO]);
            }

            // 4. Limpiar facturas_generadas_at en las órdenes relacionadas
            foreach ($factura->ordenes as $orden) {
                // Solo si no tiene otras facturas ACTIVAS vinculadas (opcional, pero por ahora lo limpiamos siempre)
                $orden->facturas_generadas_at = null;
                $orden->save();
            }

            return true;
        });
    }
}
