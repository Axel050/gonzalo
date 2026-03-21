<?php

namespace App\Services;

use App\Models\Factura;
use Exception;
use Illuminate\Support\Facades\Log;

class AfipService
{
  protected $enabled;

  public function __construct()
  {
    $this->enabled = config('services.afip.enabled', false);
  }

  /**
   * Intenta autorizar una factura en AFIP.
   * Si la integración no está habilitada, retorna null o false.
   * Si está habilitada, conectaría al WSFE.
   */
  public function autorizarFactura(Factura $factura)
  {
    if (!$this->enabled) {
      Log::info("AFIP: Integración deshabilitada. Factura {$factura->id} guardada sin CAE.");
      return [
        'cae' => null,
        'vto_cae' => null,
        'resultado' => 'local'
      ];
    }

    // --- MOCK DE INTEGRACIÓN FUTURA ---
    // Aquí iría la lógica real usando afipsdk/afip.php
    // $afip = new \Afip(['CUIT' => ...]);
    // $data = [ ... mapeo de datos de $factura ... ];
    // $res = $afip->ElectronicBilling->CreateVoucher($data);

    Log::warning("AFIP: Lógica de conexión no implementada aún.");
    return null;
  }

  /**
   * Obtener tipos de comprobantes disponibles en AFIP.
   */
  public function getTiposComprobantes()
  {
    // Retornar lista hardcodeada por ahora, coincidente con AFIP
    return [
      1 => 'Factura A',
      6 => 'Factura B',
      11 => 'Factura C',
      // ...
    ];
  }
}
