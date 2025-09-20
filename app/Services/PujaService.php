<?php

namespace App\Services;

use App\Enums\LotesEstados;
use App\Events\PujaRealizada;
use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Puja;
use App\Models\Subasta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use DomainException;

class PujaService
{


  public function registrarPuja(int $adquirenteId, int $loteId, int $monto, int $ultimoMontoVisto): array
  {
    info("registrar PUJA SERVICE");



    if (!$adquirenteId) {
      throw new InvalidArgumentException('Adquirente no especificado');
    }

    if (!$loteId || !$monto) {
      throw new InvalidArgumentException('Lote y monto son requeridos');
    }

    $lote = Lote::find($loteId);
    if (!$lote) {
      throw new ModelNotFoundException('Lote no encontrado');
    }

    if ($lote->estado != LotesEstados::EN_SUBASTA) {
      throw new DomainException('Lote no disponible');
    }

    if ($lote->fraccion_min > $monto) {
      throw new DomainException('Monto insuficiente');
    }

    $subasta = Subasta::find($lote->ultimoContrato?->subasta_id);
    if (!$subasta) {
      throw new ModelNotFoundException('Subasta no encontrada');
    }



    $adquirente = Adquirente::find($adquirenteId);
    if (!$adquirente) {
      throw new ModelNotFoundException('Adquirente no encontrado');
    }

    if (
      $adquirente?->estado_id != 1 && !$adquirente?->garantia($lote->ultimoContrato?->subasta_id)
    ) {
      throw new DomainException('No puedes participar de esta subata aun');
    }


    if ($lote->comitente?->mail == $adquirente->user?->email) {
      throw new DomainException('No puedes pujar por tu lote');
    }


    $existsInCarrito = $adquirente->carrito?->carritoLotes()
      ->where('lote_id', $loteId)
      ->exists();

    info(" PUJA SERVICE EXIST");
    if (!$existsInCarrito) {
      throw new DomainException('Lote no encontrado en carrito');
    }

    info(" PUJA Contrato Lotes");
    $contratoLote = $lote->contratoLotes()
      ->whereHas('contrato', fn($q) => $q->where('subasta_id', $subasta->id))
      ->first();

    // info(" PUJA isACtiva");
    // if (!$subasta->isActiva() || !$contratoLote || !$contratoLote->isActivo()) {
    if (!$subasta->isActiva()) {
      throw new DomainException('Subasta  inactiva');
    }

    if (!$contratoLote || !$contratoLote->isActivo()) {
      throw new DomainException('Lote inactivo');
    }

    // info(" PUJA FINAL");
    if ($lote->getPujaFinal()?->adquirente_id == $adquirenteId) {
      throw new DomainException('Tu oferta es la última');
    }

    $ultimoMonto = Puja::where('lote_id', $lote->id)
      ->where('subasta_id', $subasta->id)
      ->orderByDesc('id')
      ->value('monto') ?? 0;

    info([" PUJA SERVICE ULTIMO MONTO" => $ultimoMonto]);
    info([" PUJA SERVICE ULTIMO MONTO visto" => $ultimoMontoVisto]);

    if ($ultimoMonto !== $ultimoMontoVisto) {
      throw new DomainException('El monto ha cambiado');
    }

    $montoFinal = $ultimoMonto + $monto;

    // info(" PUJA SERVICE PUJA_CREATE");
    $puja = Puja::create([
      'adquirente_id' => $adquirenteId,
      'lote_id' => $lote->id,
      'subasta_id' => $subasta->id,
      'monto' => $montoFinal,
    ]);

    if (now()->gt($subasta->fecha_fin)) {
      $contratoLote->update([
        'tiempo_post_subasta_fin' => now()->addMinutes($subasta->tiempo_post_subasta)
      ]);
    }

    // info("ANTES EVENT");
    event(new PujaRealizada($lote->id, $montoFinal, $puja->id));

    // info("DESPUES EVENT");
    return [
      'success' => true,
      'message' => [
        'monto_final' => $montoFinal,
        'lote_id' => $lote->id,
        'subasta_id' => $subasta->id
      ],
      'code' => 200
    ];
  }
}
