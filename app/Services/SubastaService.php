<?php

namespace App\Services;

use App\Enums\LotesEstados;
use App\Models\Lote;
use App\Models\Subasta;

class SubastaService
{



  public function getLotesActivos(Subasta $subasta, bool $conCaracteristicas = false)
  {
    if (!$subasta->isActiva()) {
      throw new \Exception('Subasta no activa', 403);
    }

    $query = $subasta->lotesActivos();

    // Si se piden características, se hace eager load
    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }

    return $query->get()->map(function ($lote) use ($subasta, $conCaracteristicas) {
      $data = [
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

      if ($conCaracteristicas) {
        // Ya están cargadas en memoria, no hace consultas extra
        $data['caracteristicas'] = $lote->valoresCaracteristicas->pluck('valor');
      }

      return $data;
    });
  }








  public function getLotesActivosaaa(Subasta $subasta)
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
        "caracteristicas" => $lote->valoresCaracteristicas()->pluck('valor')
      ];
    });
  }


  public function getLotesActivosDestacadosHome()
  {


    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('lotes.estado', LotesEstados::EN_SUBASTA)
      ->where('contrato_lotes.estado', 'activo')
      ->where('lotes.destacado', true) // Filtro añadido
      ->where(function ($query) {
        $query
          ->whereNull('contrato_lotes.tiempo_post_subasta_fin')
          ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '>=', now());
      })
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',
      );


    return $query->get()->map(function ($lote) {
      return [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'precio_base' => $lote->precio_base,
        'puja_actual' => $lote->pujas->first()?->monto,
        'moneda_id' => $lote->moneda_id,
        'tienePujas' => $lote->pujas()->exists(),
        'estado_lote' => $lote->lote_estado,
      ];
    });
  }

  public function getLotesActivosDestacadosHomeFoto()
  {


    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('lotes.estado', LotesEstados::EN_SUBASTA)
      ->where('contrato_lotes.estado', 'activo')
      ->where('lotes.destacado', true) // Filtro añadido
      ->where(function ($query) {
        $query
          ->whereNull('contrato_lotes.tiempo_post_subasta_fin')
          ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '>=', now());
      })
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',
      );


    return $query->get()->map(function ($lote) {
      return [
        'id' => $lote->id,
        'foto' => $lote->foto1,
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




  public function getLotesProximos(Subasta $subasta, bool $conCaracteristicas = false)
  {

    if (!$subasta->isProxima()) {
      throw new \Exception('Subasta no disponible', 403);
    }

    $query = $subasta->lotesProximos();

    // Si se piden características, se hace eager load
    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }


    return $query->get()->map(function ($lote) use ($subasta, $conCaracteristicas) {
      $data = [
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

      if ($conCaracteristicas) {
        // Ya están cargadas en memoria, no hace consultas extra
        $data['caracteristicas'] = $lote->valoresCaracteristicas->pluck('valor');
      }

      return $data;
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




  public function getLotesPasados(Subasta $subasta, bool $conCaracteristicas = false)
  {

    if (!$subasta->isPasada()) {
      throw new \Exception('Subasta no disponible', 403);
    }

    $query = $subasta->lotesPasados();

    // Si se piden características, se hace eager load
    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }



    return $query->get()->map(function ($lote) use ($subasta, $conCaracteristicas) {
      $data = [
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

      if ($conCaracteristicas) {
        // Ya están cargadas en memoria, no hace consultas extra
        $data['caracteristicas'] = $lote->valoresCaracteristicas->pluck('valor');
      }

      return $data;
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
