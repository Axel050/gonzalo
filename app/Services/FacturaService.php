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
    $factura = $this->crearFactura($adquirente, 'venta_lote', 'P', $items, $total, $observaciones);

    // Actualizar estado de los lotes a VENDIDO
    foreach ($lotesVenta as $loteData) {
      $lote = Lote::find($loteData['lote_id']);
      if ($lote) {
        $lote->estado = LotesEstados::VENDIDO;
        $lote->save();
      }
    }

    return $factura;
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
          'venta_lote',
          'P',
          $itemsPapel,
          $totalPapel,
          "Factura martillo Orden #{$orden->id}"
        );

        $facturaPapel->orden_id = $orden->id;
        $facturaPapel->save();

        $facturasGeneradas[] = $facturaPapel;
      }


      /*
        ========================
        FACTURA COMISION
        ========================
        */

      $porcentaje = $orden->porcentaje_comision ?? 20;

      $totalComision = $orden->monto_comision ?? ($totalPapel * $porcentaje / 100);

      // if ($totalComision > 100000) {
      if ($totalComision > 0) {

        $itemsComision = [
          [
            'concepto' => "Comisión subasta {$porcentaje}% Orden #{$orden->id}",
            'precio' => $totalComision,
            'lote_id' => null,
            'subasta_id' => $orden->subasta->id ?? null
          ]
        ];

        $facturaComision = $this->crearFactura(
          $adquirente,
          'comision',
          'C',
          $itemsComision,
          $totalComision,
          "Comisión Orden #{$orden->id}"
        );

        $facturaComision->orden_id = $orden->id;
        $facturaComision->save();

        $facturasGeneradas[] = $facturaComision;
      }


      /*
        ========================
        FACTURA ENVIO
        ========================
        */

      // if ($orden->monto_envio && $orden->monto_envio > 10000)} {
      if ($orden->monto_envio && $orden->monto_envio > 0) {

        $itemsEnvio = [
          [
            'concepto' => "Servicio de envío Orden #{$orden->id}",
            'precio' => $orden->monto_envio,
            'lote_id' => null,
            'subasta_id' => $orden->subasta->id ?? null
          ]
        ];

        $facturaEnvio = $this->crearFactura(
          $adquirente,
          'envio',
          'C',
          $itemsEnvio,
          $orden->monto_envio,
          "Envío Orden #{$orden->id}"
        );

        $facturaEnvio->orden_id = $orden->id;
        $facturaEnvio->save();

        $facturasGeneradas[] = $facturaEnvio;
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
   * Genera todas las facturas necesarias para una Orden (Venta Lote, Comisión, Envío).
   */
  public function generarFacturasDesdeOrden3(\App\Models\Orden $orden)
  {
    info("IN SERVICE");
    DB::beginTransaction();
    try {
      $adquirente = $orden->adquirente;
      if (!$adquirente) throw new Exception("La orden no tiene un adquirente asociado.");

      $facturasGeneradas = [];

      // 1. Factura PAPEL (Venta de Lotes / Martillo Puro)
      $lotesVenta = $orden->lotes->map(function ($item) {
        return [
          'lote_id' => $item->lote_id,
          'precio' => $item->precio_final
        ];
      })->toArray();

      $itemsPapel = [];
      $totalPapel = 0;
      foreach ($lotesVenta as $loteData) {
        $lote = Lote::find($loteData['lote_id']);
        if (!$lote) continue;
        $subasta = $orden->subasta; // Asumimos que la orden tiene una subasta asociada
        $subastaTitulo = $subasta ? $subasta->titulo : 'XXX';
        $subastaId = $subasta ? $subasta->id : null;

        $itemsPapel[] = [
          'concepto' => "Por la venta por cuenta y orden del lote {$lote->numero} de la subasta {$subastaTitulo}",
          'precio' => $loteData['precio'],
          'lote_id' => $lote->id,
          'subasta_id' => $subastaId
        ];
        $totalPapel += $loteData['precio'];
      }

      info("ANTES DE CREAR FACTURA PAPEL", [
        "itemsPapel" => $itemsPapel,
        "totalPapel" => $totalPapel
      ]);
      $facturaPapel = $this->crearFactura(
        $adquirente,
        'venta_lote',
        'P',
        $itemsPapel,
        $totalPapel,
        "Factura generada desde Orden #{$orden->id}"
      );
      info("DESPUES DE CREAR FACTURA PAPEL", [
        "facturaPapel" => $facturaPapel
      ]);
      $facturaPapel->orden_id = $orden->id;
      $facturaPapel->save();
      $facturasGeneradas[] = $facturaPapel;

      // 2. Factura de Comisión (Venta de Lotes)
      // Se puede calcular sobre el subtotal o item por item. 
      // Usamos la comisión configurada en el adquirente o subasta.
      $subastaObj = $orden->subasta;
      $porcentajeComision = $orden->porcentaje_comision;
      if ($porcentajeComision === null && $totalPapel > 0 && $orden->monto_comision !== null) {
        $porcentajeComision = round(($orden->monto_comision * 100) / $totalPapel, 2);
      }
      if ($porcentajeComision === null) {
        $porcentajeComision = $adquirente->comision ?? $subastaObj->comision ?? 20;
      }

      $totalComision = $orden->monto_comision ?? (($totalPapel * $porcentajeComision) / 100);

      $itemsComision = [
        [
          'concepto' => "Comisión por compra en subasta ({$porcentajeComision}%) sobre Orden #{$orden->id}",
          'precio' => $totalComision,
          'lote_id' => null,
          'subasta_id' => $subastaObj->id ?? null
        ]
      ];

      $facturaComision = $this->crearFactura($adquirente, 'comision', 'A', $itemsComision, $totalComision, "Comisión generada desde Orden #{$orden->id}");
      $facturaComision->orden_id = $orden->id;
      $facturaComision->save();
      $facturasGeneradas[] = $facturaComision;

      // 3. Factura de Envío (si aplica)
      if ($orden->monto_envio > 0) {
        $facturaEnvio = $this->crearFacturaEnvio($adquirente, $orden->monto_envio, "Cargo de envío Orden #{$orden->id}");
        $facturaEnvio->orden_id = $orden->id;
        $facturaEnvio->save();
        $facturasGeneradas[] = $facturaEnvio;
      }

      DB::commit();

      // Intentar autorizar Facturas Electrónicas (Tipo A/B/C) en AFIP
      foreach ($facturasGeneradas as $f) {
        if ($f->tipo_comprobante !== 'P') { // Solo electrónicas
          try {
            // $this->autorizarEnAfip($f);
          } catch (Exception $e) {
            Log::error("Error AFIP diferido para Orden #{$orden->id}, Factura #{$f->id}: " . $e->getMessage());
          }
        }
      }

      return $facturasGeneradas;
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


  /**
   * Método genérico para crear facturas.
   */
  private function crearFacturawww(Adquirente $adquirente, $tipoConcepto, $tipoComprobante, $items, $total, $observaciones = null)
  {
    info(["crear factua" => [
      "adquirente_id" => $adquirente->id,
      "tipo_concepto" => $tipoConcepto,
      "tipo_comprobante" => $tipoComprobante,
      "total" => $total,
      "observaciones" => $observaciones
    ]]);

    DB::beginTransaction();
    try {
      $factura = Factura::create([
        'adquirente_id' => $adquirente->id,
        'fecha' => now(),
        'tipo_concepto' => $tipoConcepto,
        'tipo_comprobante' => $tipoComprobante,
        'monto_total' => $total,
        'estado' => 'pendiente',
        'nombre' => $adquirente->nombre,
        'apellido' => $adquirente->apellido,
        'cuit' => $adquirente->cuit,
        'dni' => $adquirente->dni,
        'direccion' => $adquirente->domicilio, // Corregido a domicilio si es el campo real
        'email' => $adquirente->user->email ?? $adquirente->email,
        'condicion_iva' => $adquirente->condicion_iva_id, // Usar ID o nombre según convenga
        'observaciones' => $observaciones,
      ]);

      info(["items a agregar a FacturaLote" => $items, "factura_id" => $factura->id]);

      foreach ($items as $item) {
        info(["item a agregar a FacturaLote" => $item, "factura_id" => $factura->id]);
        FacturaLote::create([
          'factura_id' => $factura->id,
          'lote_id' => $item['lote_id'] ?? null,
          'subasta_id' => $item['subasta_id'] ?? null,
          'concepto' => $item['concepto'],
          'precio' => $item['precio']
        ]);
      }


      DB::commit();


      // Intentar autorizar con AFIP (si es electrónica)
      // if ($tipoComprobante !== 'P') {
      //   try {
      //     $this->autorizarEnAfip($factura);
      //   } catch (Exception $e) {
      //     Log::error("Error AFIP inmediato para Factura {$factura->id}: " . $e->getMessage());
      //   }
      // }

      return $factura;
    } catch (Exception $e) {
      info("Error al crear factura: " . $e->getMessage());
      DB::rollBack();
      throw $e;
    }
  }
}
