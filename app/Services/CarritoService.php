<?php

namespace App\Services;

use App\Models\Adquirente;
use App\Models\Carrito;
use App\Models\Lote;
use App\Models\Subasta;
use DomainException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarritoService
{

  public function agregar(int $adquirenteId, int $loteId): void
  {
    $lote = Lote::find($loteId);
    if (!$lote) {
      throw new ModelNotFoundException('Lote no encontrado');
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

    if (!in_array($subasta->estado, ['activa', 'enpuja'])) {
      throw new DomainException('La subasta no está activa ni en fase de puja');
    }

    if ($lote->estado !== 'ensubasta') {
      throw new DomainException('Lote no disponible para subasta');
    }

    $contratoLote = $lote->ultimoConLote;
    if (!$contratoLote) {
      throw new DomainException('No hay un contrato activo para este lote');
    }

    if ($contratoLote->tiempo_post_subasta_fin && now()->gt($contratoLote->tiempo_post_subasta_fin)) {
      throw new DomainException('El tiempo de puja extendida ha expirado');
    }

    DB::transaction(function () use ($lote, $subasta, $adquirenteId) {
      $carrito = Carrito::firstOrCreate(
        ['adquirente_id' => $adquirenteId, 'estado' => 'activo']
      );

      $exists = $carrito->carritoLotes()->where('lote_id', $lote->id)->exists();
      if ($exists) {
        throw new DomainException('El lote ya está en el carrito');
      }

      $carrito->carritoLotes()->create([
        'lote_id' => $lote->id,
        'subasta_id' => $subasta->id,
      ]);
    });
  }



  public function quitar(int $adquirenteId, int $loteId)
  {
    if (!$adquirenteId) {
      throw new InvalidArgumentException('Adquirente no especificado');
    }

    if (!$loteId) {
      throw new InvalidArgumentException('Lote no especificado');
    }

    $carrito = Carrito::where('adquirente_id', $adquirenteId)
      ->where('estado', 'activo')
      ->firstOr(function () {
        throw new ModelNotFoundException("Carrito no encontrado", 404);
      });


    $carritoLote = $carrito->carritoLotes()->where('lote_id', $loteId)
      ->firstOr(function () {
        throw new ModelNotFoundException("Lote  no encontrado en carrito", 404);
      });

    $carritoLote->delete();
  }
}
