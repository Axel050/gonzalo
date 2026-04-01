<?php

namespace App\Services;

use App\Models\Factura;
use App\Models\FacturaLote;
use App\Models\Adquirente;
use App\Models\Lote;
use App\Enums\LotesEstados;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

use App\Services\AfipService;

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
        'subasta_id' => null
      ]
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
        'subasta_id' => null
      ]
    ];
    return $this->crearFactura($adquirente, 'envio', 'A', $items, $monto, $observaciones);
  }

  /**
   * Crea la factura PAPEL con los lotes y el martillo puro.
   * Actualiza el estado de los lotes a VENDIDO.
   */
  public function crearFacturaPapel(Adquirente $adquirente, $lotesVenta, $observaciones = null)
  {
    $items = [];
    $total = 0;

    foreach ($lotesVenta as $loteData) {
      $lote = Lote::find($loteData['lote_id']);
      if (!$lote) continue;

      $precio = $loteData['precio']; // Martillo puro

      // Obtener subasta (la más reciente asociada al lote)
      $subasta = $lote->subastas()->latest('id')->first();
      $subastaTitulo = $subasta ? $subasta->titulo : 'XXX';
      $subastaId = $subasta ? $subasta->id : null;

      if (!$subastaId) {
        // Fallback: tratar de obtener de la última puja si existe
        $ultimaPuja = $lote->pujas()->latest()->first();
        // Si la puja tuviera subasta_id... pero Puja suele tener solo lote_id y usuario_id.
        // Asumimos que debe haber relación Lote-Subasta.
      }

      $concepto = "Por la venta por cuenta y orden del lote {$lote->numero} de la subasta {$subastaTitulo}";

      $items[] = [
        'concepto' => $concepto,
        'precio' => $precio,
        'lote_id' => $lote->id,
        'subasta_id' => $subastaId
      ];
      $total += $precio;
    }

    // Crear la factura
    $factura = $this->crearFactura($adquirente, 'martillo', 'P', $items, $total, $observaciones);

    // Actualizar estado de los lotes a FACTURADO
    foreach ($lotesVenta as $loteData) {
      $lote = Lote::find($loteData['lote_id']);
      if ($lote) {
        $lote->estado = LotesEstados::FACTURADO;
        $lote->save();
      }
    }

    return $factura;
  }


  public function generarFacturasAgrupadas(array $ordenesIds)
  {
    DB::beginTransaction();

    try {

      $ordenes = \App\Models\Orden::with(['lotes.lote', 'adquirente', 'subasta'])
        ->whereIn('id', $ordenesIds)
        ->get();

      if ($ordenes->isEmpty()) {
        throw new Exception("No hay órdenes seleccionadas.");
      }

      // ✅ mismo adquirente
      $adquirente = $ordenes->first()->adquirente;

      foreach ($ordenes as $orden) {

        if ($orden->adquirente_id !== $adquirente->id) {
          throw new Exception("Todas las órdenes deben ser del mismo adquirente.");
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
          if (!$lote) continue;

          $precio = $ordenLote->precio_final;

          $itemsMartillo[] = [
            'concepto' => "Orden #{$orden->id} - Lote {$lote->id} ({$orden->subasta?->titulo})",
            'precio' => $precio,
            'lote_id' => $lote->id,
            'subasta_id' => $orden->subasta->id ?? null
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
        $baseOrden = $orden->lotes->sum('precio_final');
        $totalComision = $orden->monto_comision ?? ($baseOrden * $porcentaje / 100);

        if ($totalComision > 0) {
          $itemsServicios[] = [
            'concepto' => "Orden #{$orden->id} - Comisión {$porcentaje}% ({$orden->subasta?->titulo})",
            'precio' => $totalComision,
            'lote_id' => null,
            'subasta_id' => $orden->subasta->id ?? null
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
            'subasta_id' => $orden->subasta->id ?? null
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
          "Facturación múltiple órdenes: " . implode(',', $ordenesIds)
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
          "Servicios múltiples órdenes: " . implode(',', $ordenesIds)
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
        'servicios' => $facturaServicios
      ];
    } catch (Exception $e) {

      DB::rollBack();
      throw $e;
    }
  }

  public function generarFacturasAgrupadassss(array $ordenesIds)
  {
    DB::beginTransaction();

    try {

      $ordenes = \App\Models\Orden::with(['lotes.lote', 'adquirente', 'subasta'])
        ->whereIn('id', $ordenesIds)
        ->get();

      if ($ordenes->isEmpty()) {
        throw new Exception("No hay órdenes seleccionadas.");
      }

      // 👉 validar mismo adquirente
      $adquirente = $ordenes->first()->adquirente;

      foreach ($ordenes as $orden) {
        if ($orden->adquirente_id !== $adquirente->id) {
          throw new Exception("Todas las órdenes deben ser del mismo adquirente.");
        }
      }

      $itemsMartillo = [];
      $totalMartillo = 0;

      $itemsServicios = [];
      $totalServicios = 0;

      foreach ($ordenes as $orden) {

        // 🚫 evitar duplicadas

        if ($orden->facturas_generadas_at) {
          throw new Exception("La orden #{$orden->id} ya fue facturada.");
        }

        /**
         * =========================
         * MARTILLO (LOTE)
         * =========================
         */
        foreach ($orden->lotes as $ordenLote) {

          $lote = $ordenLote->lote;
          if (!$lote) continue;

          $precio = $ordenLote->precio_final;

          $itemsMartillo[] = [
            'concepto' => "Orden #{$orden->id} - Lote {$lote->id} ({$orden->subasta?->titulo})",
            'precio' => $precio,
            'lote_id' => $lote->id,
            'subasta_id' => $orden->subasta->id ?? null
          ];

          $totalMartillo += $precio;

          // actualizar estado
          $lote->estado = LotesEstados::FACTURADO;
          $lote->save();
        }




        /**
         * =========================
         * COMISION
         * =========================
         */
        $porcentaje = $orden->porcentaje_comision ?? 20;
        $baseOrden = $orden->lotes->sum('precio_final');
        $totalComision = $orden->monto_comision ?? ($baseOrden * $porcentaje / 100);

        if ($totalComision > 0) {
          $itemsServicios[] = [
            'concepto' => "Orden #{$orden->id} - Comisión {$porcentaje}% ({$orden->subasta?->titulo})",
            'precio' => $totalComision,
            'lote_id' => null,
            'subasta_id' => $orden->subasta->id ?? null
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
            'subasta_id' => $orden->subasta->id ?? null
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
          "Facturación múltiple órdenes: " . implode(',', $ordenesIds)
        );
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
          "Servicios múltiples órdenes: " . implode(',', $ordenesIds)
        );
      }

      DB::commit();
      return [
        'martillo' => $facturaMartillo,
        'servicios' => $facturaServicios
      ];
    } catch (Exception $e) {
      info(["exception " => $e]);
      DB::rollBack();
      throw $e;
    }
  }


  public function generarFacturasDesdeOrden(\App\Models\Orden $orden)
  {
    DB::beginTransaction();

    try {

      $orden->load(['lotes.lote', 'adquirente', 'subasta']);

      $adquirente = $orden->adquirente;

      if (!$adquirente) {
        throw new Exception("La orden no tiene adquirente.");
      }

      // Evitar duplicar facturas
      $facturasExistentes = Factura::where('orden_id', $orden->id)->count();

      if ($facturasExistentes > 0) {
        throw new Exception("Esta orden ya tiene facturas generadas.");
      }

      $facturasGeneradas = [];

      /*
        =========================================
        FACTURA PAPEL (VENTA DE LOTES / MARTILLO)
        =========================================
        */

      $itemsPapel = [];
      $totalPapel = 0;

      foreach ($orden->lotes as $ordenLote) {

        $lote = $ordenLote->lote;

        if (!$lote) continue;

        $precio = $ordenLote->precio_final;

        $itemsPapel[] = [
          'concepto' => "Venta por cuenta y orden lote {$lote->id} - Subasta {$orden->subasta->titulo}",
          'precio' => $precio,
          'lote_id' => $lote->id,
          'subasta_id' => $orden->subasta->id ?? null
        ];

        $totalPapel += $precio;
      }

      if ($totalPapel > 0) {

        $facturaPapel = $this->crearFactura(
          $adquirente,
          'martillo',
          'P',
          $itemsPapel,
          $totalPapel,
          "Factura martillo Orden #{$orden->id}"
        );

        $facturaPapel->orden_id = $orden->id;
        $facturaPapel->save();

        $facturasGeneradas[] = $facturaPapel;
      }

      /* ========================
FACTURA COMISION + ENVIO
======================== */

      $itemsAdicionales = [];
      $totalAdicionales = 0;

      /**
       * COMISION
       */
      $porcentaje = $orden->porcentaje_comision ?? 20;
      $totalComision = $orden->monto_comision ?? ($totalPapel * $porcentaje / 100);

      if ($totalComision > 0) {
        $itemsAdicionales[] = [
          'concepto' => "Comisión subasta {$porcentaje}% Orden #{$orden->id}",
          'precio' => $totalComision,
          'lote_id' => null,
          'subasta_id' => $orden->subasta->id ?? null
        ];

        $totalAdicionales += $totalComision;
      }

      /**
       * ENVIO
       */
      if ($orden->monto_envio && $orden->monto_envio > 0) {
        $itemsAdicionales[] = [
          'concepto' => "Servicio de envío Orden #{$orden->id}",
          'precio' => $orden->monto_envio,
          'lote_id' => null,
          'subasta_id' => $orden->subasta->id ?? null
        ];

        $totalAdicionales += $orden->monto_envio;
      }

      /**
       * CREAR UNA SOLA FACTURA SI HAY ITEMS
       */
      if ($totalAdicionales > 0) {

        $facturaAdicional = $this->crearFactura(
          $adquirente,
          'servicios', // 👈 podés usar un tipo nuevo o 'comision'
          'C',
          $itemsAdicionales,
          $totalAdicionales,
          "Servicios Orden #{$orden->id}"
        );

        $facturaAdicional->orden_id = $orden->id;
        $facturaAdicional->save();

      // vincular facturas para mostrar total conjunto en listados
      if (isset($facturaPapel) && isset($facturaAdicional) && $facturaPapel && $facturaAdicional) {
        $facturaPapel->factura_asociada_id = $facturaAdicional->id;
        $facturaAdicional->factura_asociada_id = $facturaPapel->id;
        $facturaPapel->save();
        $facturaAdicional->save();
      }


        $facturasGeneradas[] = $facturaAdicional;
      }

      DB::commit();

      return $facturasGeneradas;
    } catch (Exception $e) {
      info("Error al generar facturas desde orden: " . $e->getMessage());
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
      Log::error("Error al autorizar AFIP factura {$factura->id}: " . $e->getMessage());
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
      'estado' => 'pendiente',
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
        'precio' => $item['precio']
      ]);
    }

    return $factura;
  }
}
