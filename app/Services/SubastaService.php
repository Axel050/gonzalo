<?php

namespace App\Services;

use App\Models\Subasta;

class SubastaService
{

  public function getLotesActivos(Subasta $subasta)
  {


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
        'descripcion' => $lote->descripcion,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
        'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
        'moneda_id' => $lote->moneda_id,
        'tienePujas' => $lote->pujas()->exists(),
      ];
    });
  }


  public function getLotesActivosDestacados(Subasta $subasta)
  {

    info("In SUBASTA SERVICE");

    if (!$subasta->isActiva()) {
      // info("NO ACRIVA ");
      throw new \Exception('Subasta no activa', 403);
    }
    // info("pasosoo");

    return $subasta->lotesActivosDestacados()->get()->map(function ($lote) use ($subasta) {
      return [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'descripcion' => $lote->descripcion,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
        'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
        'moneda_id' => $lote->moneda_id,
        'tienePujas' => $lote->pujas()->exists(),
        'estado_lote' => $lote->lote_estado,
      ];
    });
  }




  public function getLotesProximos(Subasta $subasta)
  {


    if (!$subasta->isProxima()) {
      throw new \Exception('Subasta no disponible', 403);
    }
    info("pasosoo");

    return $subasta->lotesProximos()->get()->map(function ($lote) use ($subasta) {
      return [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'descripcion' => $lote->descripcion,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
        'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
        'moneda_id' => $lote->moneda_id,
      ];
    });
  }


  public function getLotesProximosDestacados(Subasta $subasta)
  {


    if (!$subasta->isProxima()) {
      throw new \Exception('Subasta no disponible', 403);
    }
    info("pasosoo");

    return $subasta->lotesProximosDestacados()->get()->map(function ($lote) use ($subasta) {
      return [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'descripcion' => $lote->descripcion,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
        'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
        'moneda_id' => $lote->moneda_id,
        'estado_lote' => $lote->lote_estado,
      ];
    });
  }




  public function getLotesPasados(Subasta $subasta)
  {

    info("PASADOS SERVIVE ");
    if (!$subasta->isPasada()) {
      throw new \Exception('Subasta no disponible', 403);
    }
    info("pasosoo");

    return $subasta->lotesPasados()->get()->map(function ($lote) use ($subasta) {
      return [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'descripcion' => $lote->descripcion,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
        'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
        'moneda_id' => $lote->moneda_id,
        'estado_lote' => $lote->lote_estado,
      ];
    });
  }





  public function getLotesPasadosDestacados(Subasta $subasta)
  {

    info("PASADOS SERVIVE ");
    if (!$subasta->isPasada()) {
      throw new \Exception('Subasta no disponible', 403);
    }
    info("pasosoo");

    return $subasta->lotesPasadosDestacados()->get()->map(function ($lote) use ($subasta) {
      return [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'descripcion' => $lote->descripcion,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
        'estado' => $lote->isActivoEnSubasta($subasta->id) ? 'activo' : 'inactivo',
        'moneda_id' => $lote->moneda_id,
        'estado_lote' => $lote->lote_estado,
      ];
    });
  }
}
