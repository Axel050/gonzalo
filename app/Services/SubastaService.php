<?php

namespace App\Services;

use App\Models\Subasta;

class SubastaService
{
  public function getLotesActivos(Subasta $subasta)
  {

    info("In SUBASTA SERVICE");

    if (!$subasta->isActiva()) {
      // info("NO ACRIVA ");
      throw new \Exception('Subasta no activa', 403);
    }
    // info("pasosoo");

    return $subasta->lotesActivos()->get()->map(function ($lote) use ($subasta) {
      return [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
        'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
      ];
    });
  }
}
