<?php

namespace App\Services;

use App\Enums\LotesEstados;
use App\Events\PujaRealizada;
use App\Mail\PujaSuperadaEmail;
use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Puja;
use App\Models\Subasta;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use DomainException;

class PujaService
{


  public function registrarPuja(int $adquirenteId, int $loteId, int $monto, int $ultimoMontoVisto): array
  {

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

    $base = $lote->ultimoConLote?->precio_base;


    if ($base  > $monto && !count($lote->pujas)) {
      throw new DomainException('Monto minino : ' .  number_format($base, 0, ',', '.'));
    }


    if (($lote->fraccion_min + $ultimoMontoVisto) > $monto) {
      $tot = $lote->fraccion_min + $ultimoMontoVisto;
      throw new DomainException('Monto minino : ' .  number_format($tot, 0, ',', '.'));
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


    if (!$existsInCarrito) {
      throw new DomainException('Lote no encontrado en carrito');
    }

    // info(" PUJA Contrato Lotes");
    $contratoLote = $lote->contratoLotes()
      ->whereHas('contrato', fn($q) => $q->where('subasta_id', $subasta->id))
      ->first();


    if (!$subasta->isActiva()) {
      throw new DomainException('Subasta  inactiva');
    }

    if (!$contratoLote || !$contratoLote->isActivo()) {
      throw new DomainException('Lote inactivo');
    }

    $ultimoAdquirente = $lote->getPujaFinal()?->adquirente_id;
    if ($ultimoAdquirente == $adquirenteId) {
      throw new DomainException('Tu oferta es la última');
    }



    $ultimaPuja = Puja::where('lote_id', $lote->id)
      ->where('subasta_id', $subasta->id)
      ->orderByDesc('id')->first();


    $ultimoMonto = $ultimaPuja ? $ultimaPuja->monto : 0;



    if ($ultimoMonto !== $ultimoMontoVisto) {
      throw new DomainException('El monto ha cambiado');
    }

    // $montoFinal = $ultimoMonto + $monto;
    $montoFinal =  $monto;


    $puja = Puja::create([
      'adquirente_id' => $adquirenteId,
      'lote_id' => $lote->id,
      'subasta_id' => $subasta->id,
      'monto' => $montoFinal,
    ]);


    $tiempoFinalizacion = "";

    if (now()->gt($subasta->fecha_fin)) {
      // info(["Contratl lotes NOW " => "ddddddd"]);
      $contratoLote->update([
        'tiempo_post_subasta_fin' => now()->addMinutes($subasta->tiempo_post_subasta),
      ]);
      $tiempoFinalizacion = $contratoLote->tiempo_post_subasta_fin->toDateTimeString();
    }


    $signo = Moneda::find($lote->moneda)?->signo;

    // info("ANTES EVENT pujarealizada");
    event(new PujaRealizada($lote->id, $montoFinal, $puja->id, $ultimoAdquirente, $signo, $adquirenteId, $tiempoFinalizacion));

    // info("DESPUES EVENT puja");


    $dataMail = [
      "monto" => $puja->monto,
      "lote_id" => $lote->id,
      "titulo" => $lote->titulo,
      "foto" => $lote->foto1,
      "subasta" => $subasta->titulo,
    ];


    if ($ultimoMonto > 0) {
      try {
        Mail::to($ultimaPuja->adquirente?->user?->email)->send(new PujaSuperadaEmail($dataMail));
      } catch (\Exception $e) {
        // Log del error para debugging, sin detener el job
        info('Error al enviar PujaSuperada en job DesactivarLotesExpirados: ' . $e->getMessage(), [
          'adquirente_id' => $adquirente->id ?? null,
          'trace' => $e->getTraceAsString(),
        ]);
      }
    }



    return [
      'success' => true,
      'message' => [
        'monto_final' => $montoFinal,
        'lote_id' => $lote->id,
        'subasta_id' => $subasta->id,
        'tiempoFinalizacion' => $tiempoFinalizacion
      ],
      'code' => 200
    ];
  }
}
