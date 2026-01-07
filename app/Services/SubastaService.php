<?php

namespace App\Services;

use App\DTOs\SubastasDTO;
use App\Enums\LotesEstados;


use App\Models\EstadosLote;
use App\Models\Lote;
use App\Models\Subasta;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SubastaService
{

  // solo ids para detalle lote
  public function getLotesActivosIds(Subasta $subasta)
  {
    if (!$subasta->isActiva()) {
      throw new \Exception('Subasta no activa', 403);
    }

    return $subasta->lotesActivos()
      ->orderBy('lotes.id')           // ← aquí sí puedes ordenar
      ->pluck('lotes.id')             // ← solo los IDs
      ->toArray();
  }

  public function getSiguienteLoteId(Subasta $subasta, int $loteId): ?int
  {
    // Trabajamos directamente con el Query Builder
    $siguiente = $subasta->lotesActivos()
      ->where('lotes.id', '>', $loteId)
      ->orderBy('lotes.id')
      ->value('lotes.id'); // → devuelve directamente el ID o null

    // Si no hay siguiente → volvemos al primero (loop)
    if (!$siguiente) {
      $siguiente = $subasta->lotesActivos()
        ->orderBy('lotes.id')
        ->value('lotes.id');
    }
    // Si no hay siguiente → volvemos al primero (loop típico en subastas)
    return $siguiente ?? $this->getLotesActivosIds($subasta)->value('lotes.id');
  }


  public function getAnteriorLoteId(Subasta $subasta, int $loteId): ?int
  {
    // Trabajamos directamente con el Query Builder
    $siguiente = $subasta->lotesActivos()
      ->where('lotes.id', '<', $loteId)
      ->orderByDesc('lotes.id')
      ->value('lotes.id'); // → devuelve directamente el ID o null

    // Si no hay siguiente → volvemos al primero (loop)
    if (!$siguiente) {
      $siguiente = $subasta->lotesActivos()
        ->orderByDesc('lotes.id', 'desc')
        ->value('lotes.id');
    }
    // Si no hay siguiente → volvemos al primero (loop típico en subastas)
    return $siguiente ?? $this->getLotesActivosIds($subasta)->value('lotes.id');
  }


  public function getLotesCASI(Subasta $subasta, bool $conCaracteristicas = false)
  {
    if (!$subasta->isActiva()) {
      throw new \Exception('Subasta no activa', 403);
    }

    $query = $subasta->lotesActivos();

    // Si se piden características, se hace eager load
    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }

    return $query
      // ->get()->map(function ($lote) use ($subasta, $conCaracteristicas) {
      ->paginate(10) // 👈 paginación aquí
      ->through(function ($lote) use ($subasta, $conCaracteristicas) {
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


  public function getLotesActivos(
    Subasta $subasta,
    ?string $search = null,
    bool $conCaracteristicas = false,
    int $page = 1,
    int $perPage = 6
  ) {
    if (! $subasta->isActiva()) {
      throw new \Exception('Subasta no activa', 403);
    }

    $query = $subasta->lotesActivos()
      ->with([
        'pujas' => fn($q) => $q->latest()->limit(1),
      ])
      ->withExists('pujas');

    // 🔍 búsqueda
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('lotes.titulo', 'like', "%{$search}%")
          ->orWhere('lotes.descripcion', 'like', "%{$search}%")
          ->orWhereHas('valoresCaracteristicas', function ($c) use ($search) {
            $c->where('valor', 'like', "%{$search}%");
          });
      });
    }

    // ⚡ solo si hace falta
    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas:id,lote_id,valor');
      // $query->with('valoresCaracteristicas');
    }

    return $query->simplePaginate(
      $perPage,
      ['*'],
      'page',
      $page
    );
  }







  public function getLotesActivosDestacadosHome()
  {
    return Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')

      // 🔥 subquery: última puja
      ->leftJoin('pujas as p', function ($join) {
        $join->on('p.lote_id', '=', 'lotes.id')
          ->whereRaw('p.id = (
                    select id from pujas
                    where pujas.lote_id = lotes.id
                    order by id desc
                    limit 1
                 )');
      })

      ->where('lotes.estado', LotesEstados::EN_SUBASTA)
      ->where('contrato_lotes.estado', 'activo')
      ->where('lotes.destacado', true)
      ->where(function ($query) {
        $query->whereNull('contrato_lotes.tiempo_post_subasta_fin')
          ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '>=', now());
      })
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')

      ->select([
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1 as foto',
        'contrato_lotes.precio_base',
        'contrato_lotes.moneda_id',
        'lotes.estado as estado_lote',

        // ✅ calculados en SQL
        DB::raw('COALESCE(p.monto, 0) as puja_actual'),
        DB::raw('CASE WHEN p.id IS NULL THEN 0 ELSE 1 END as tienePujas'),
      ])

      ->get();
  }

  public function getLotesActivosDestacadosHomeee()
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


  public function getLotesActivosDestacado2s(Subasta $subasta)
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







  public function getLotesProximos(
    Subasta $subasta,
    ?string $search = null,
    bool $conCaracteristicas = false,
    int $page = 1,
    int $perPage = 4
  ) {
    $query = $subasta->lotesProximos();

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('lotes.titulo', 'like', "%{$search}%")
          ->orWhere('lotes.descripcion', 'like', "%{$search}%")

          ->orWhereHas('valoresCaracteristicas', function ($c) use ($search) {
            $c->where('valor', 'like', "%{$search}%");
          });
      });
    }

    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }

    return $query->simplePaginate(
      $perPage,
      ['*'],
      'page',
      $page
    );
  }









  public function getLotesProximosxxx(
    Subasta $subasta,
    ?string $search = null,
    bool $conCaracteristicas = false,
    int $page = 1,
    int $perPage = 4
  ) {
    $query = $subasta->lotesProximos();

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('lotes.titulo', 'like', "%{$search}%")
          ->orWhere('lotes.descripcion', 'like', "%{$search}%")
          ->orWhereHas('valoresCaracteristicas', function ($c) use ($search) {
            $c->where('valor', 'like', "%{$search}%");
          });
      });
    }

    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }

    // return $query->paginate(
    //   $perPage,
    //   ['*'],
    //   'page',
    //   $page
    // );
    // if ($search) {
    //   return $query->paginate($perPage, ['*'], 'page', $page);
    // }

    // return $query->simplePaginate($perPage, ['*'], 'page', $page);

    return $query->simplePaginate($perPage);
  }













  public function getLotesProximosaaa(
    Subasta $subasta,
    ?string $search = null,
    bool $conCaracteristicas = false
  ) {
    if (!$subasta->isProxima()) {
      throw new \Exception('Subasta no disponible', 403);
    }

    $query = $subasta->lotesProximos();

    if ($search) {
      $query->where(function ($q) use ($search) {

        // 🔹 título y descripción
        $q->where('lotes.titulo', 'like', "%{$search}%")
          ->orWhere('lotes.descripcion', 'like', "%{$search}%")

          // 🔹 características
          ->orWhereHas('valoresCaracteristicas', function ($c) use ($search) {
            $c->where('valor', 'like', "%{$search}%");
          });
      });
    }

    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }

    return $query
      ->paginate(2)
      ->through(function ($lote) use ($subasta, $conCaracteristicas) {

        $data = [
          'id' => $lote->id,
          'titulo' => $lote->titulo,
          'foto' => $lote->foto1,
          'descripcion' => $lote->descripcion,
          'precio_base' => $lote->precio_base,
          'moneda_id' => $lote->moneda_id,
        ];

        if ($conCaracteristicas) {
          $data['caracteristicas'] =
            $lote->valoresCaracteristicas->pluck('valor');
        }

        return $data;
      });
  }


  public function getLotesProximosOLDSubasta($subasta, bool $conCaracteristicas = false)
  {

    if (!$subasta->isProxima()) {
      throw new \Exception('Subasta no disponible', 403);
    }

    $query = $subasta->lotesProximos();

    // Si se piden características, se hace eager load
    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas');
    }


    return $query
      // ->get()->map(function ($lote) use ($subasta, $conCaracteristicas) {
      ->paginate(10) // 👈 paginación aquí
      ->through(function ($lote) use ($subasta, $conCaracteristicas) {
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



  // solo ids para detalle lote
  public function getLotesProximosIds(Subasta $subasta)
  {
    if (!$subasta->isProxima()) {
      throw new \Exception('Subasta no activa', 403);
    }

    return $subasta->lotesProximos()
      ->where('lotes.estado', LotesEstados::ASIGNADO)
      ->orderBy('lotes.id')           // ← aquí sí puedes ordenar
      ->pluck('lotes.id')             // ← solo los IDs
      ->toArray();
  }

  public function getSiguienteLoteIdProximos(Subasta $subasta, int $loteId): ?int
  {

    // Trabajamos directamente con el Query Builder
    $siguiente = $subasta->lotesProximos()
      ->where('lotes.id', '>', $loteId)
      ->where('lotes.estado', LotesEstados::ASIGNADO)
      ->orderBy('lotes.id')
      ->value('lotes.id'); // → devuelve directamente el ID o null

    // Si no hay siguiente → volvemos al primero (loop)
    if (!$siguiente) {
      $siguiente = $subasta->lotesProximos()
        ->where('lotes.estado', LotesEstados::ASIGNADO)
        ->orderBy('lotes.id')
        ->value('lotes.id');
    }
    // Si no hay siguiente → volvemos al primero (loop típico en subastas)
    return $siguiente ?? $this->getLotesProximosIds($subasta)->value('lotes.id');
  }


  public function getAnteriorLoteIdProximos(Subasta $subasta, int $loteId): ?int
  {

    // Trabajamos directamente con el Query Builder
    $siguiente = $subasta->lotesProximos()
      ->where('lotes.estado', LotesEstados::ASIGNADO)
      ->where('lotes.id', '<', $loteId)
      ->orderByDesc('lotes.id')
      ->value('lotes.id'); // → devuelve directamente el ID o null

    // Si no hay siguiente → volvemos al primero (loop)
    if (!$siguiente) {
      $siguiente = $subasta->lotesProximos()
        ->where('lotes.estado', LotesEstados::ASIGNADO)
        ->orderByDesc('lotes.id', 'desc')
        ->value('lotes.id');
    }
    // Si no hay siguiente → volvemos al primero (loop típico en subastas)
    return $siguiente ?? $this->getLotesProximosIds($subasta)->value('lotes.id');
  }






  public function getLotesProximosDestacados22(Subasta $subasta)
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



  public function getLotesPasados(
    Subasta $subasta,
    ?string $search = null,
    bool $conCaracteristicas = false,
    int $page = 1,
    int $perPage = 6
  ) {
    if (!$subasta->isPasada()) {
      throw new \Exception('Subasta no disponible', 403);
    }

    $query = $subasta->lotesPasados()
      ->with([
        'pujas' => fn($q) => $q->latest()->limit(1),
      ])
      ->withExists('pujas');


    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('lotes.titulo', 'like', "%{$search}%")
          ->orWhere('lotes.descripcion', 'like', "%{$search}%")
          ->orWhereHas('valoresCaracteristicas', function ($c) use ($search) {
            $c->where('valor', 'like', "%{$search}%");
          });
      });
    }


    if ($conCaracteristicas) {
      $query->with('valoresCaracteristicas:id,lote_id,valor');
      // $query->with('valoresCaracteristicas');
    }


    return $query->simplePaginate(
      $perPage,
      ['*'],
      'page',
      $page
    );
  }


  public function getLotesPasadosOOO(Subasta $subasta, bool $conCaracteristicas = false)
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



  // solo ids para detalle lote
  public function getLotesPasadosIds(Subasta $subasta)
  {
    if (!$subasta->isPasada()) {
      throw new \Exception('Subasta no activa', 403);
    }
    $estadosAFiltrar = [
      LotesEstados::STANDBY, // Asumo que tienes una constante para 'standby'
      LotesEstados::DISPONIBLE // Asumo que tienes una constante para 'disponible'
    ];
    return $subasta->lotesPasados()
      ->whereIn('lotes.estado', $estadosAFiltrar)
      ->orderBy('lotes.id')           // ← aquí sí puedes ordenar
      ->pluck('lotes.id')             // ← solo los IDs
      ->toArray();
  }

  public function getSiguienteLoteIdPasado(Subasta $subasta, int $loteId): ?int
  {
    $estadosAFiltrar = [
      LotesEstados::STANDBY,
      LotesEstados::DISPONIBLE
    ];
    // Trabajamos directamente con el Query Builder
    $siguiente = $subasta->lotesPasados()
      ->where('lotes.id', '>', $loteId)
      ->whereIn('lotes.estado', $estadosAFiltrar)
      ->orderBy('lotes.id')
      ->value('lotes.id'); // → devuelve directamente el ID o null

    // Si no hay siguiente → volvemos al primero (loop)
    if (!$siguiente) {
      $siguiente = $subasta->lotesPasados()
        ->whereIn('lotes.estado', $estadosAFiltrar)
        ->orderBy('lotes.id')
        ->value('lotes.id');
    }
    // Si no hay siguiente → volvemos al primero (loop típico en subastas)
    return $siguiente ?? $this->getLotesPasadosIds($subasta)->value('lotes.id');
  }


  public function getAnteriorLoteIdPasado(Subasta $subasta, int $loteId): ?int
  {
    $estadosAFiltrar = [
      LotesEstados::STANDBY,
      LotesEstados::DISPONIBLE
    ];
    // Trabajamos directamente con el Query Builder
    $siguiente = $subasta->lotesPasados()
      ->whereIn('lotes.estado', $estadosAFiltrar)
      ->where('lotes.id', '<', $loteId)
      ->orderByDesc('lotes.id')
      ->value('lotes.id'); // → devuelve directamente el ID o null

    // Si no hay siguiente → volvemos al primero (loop)
    if (!$siguiente) {
      $siguiente = $subasta->lotesPasados()
        ->whereIn('lotes.estado', $estadosAFiltrar)
        ->orderByDesc('lotes.id', 'desc')
        ->value('lotes.id');
    }
    // Si no hay siguiente → volvemos al primero (loop típico en subastas)
    return $siguiente ?? $this->getLotesPasadosIds($subasta)->value('lotes.id');
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











  public function buscarLotes(
    ?string $search = null,
    int $page = 1,
    int $perPage = 6
  ) {
    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->join('subastas', 'contratos.subasta_id', '=', 'subastas.id')
      ->leftJoin(
        'valores_cataracteristicas as vc',
        'vc.lote_id',
        '=',
        'lotes.id'
      )

      ->leftJoin('pujas as p', function ($join) {
        $join->on('p.lote_id', '=', 'lotes.id')
          ->whereRaw('p.id = (
                     select id from pujas 
                     where pujas.lote_id = lotes.id 
                     order by id desc limit 1
                 )');
      })


      // 🔒 reglas de negocio fijas
      ->whereIn('lotes.estado', [
        LotesEstados::EN_SUBASTA,
        LotesEstados::ASIGNADO,
        LotesEstados::DISPONIBLE,
      ])
      ->where('contrato_lotes.estado', 'activo')
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')

      // 🔍 búsqueda
      ->when($search, function ($q) use ($search) {
        $q->where(function ($qq) use ($search) {
          $qq->where('lotes.titulo', 'like', "%{$search}%")
            ->orWhere('lotes.descripcion', 'like', "%{$search}%")
            ->orWhere('vc.valor', 'like', "%{$search}%");
        });
      })

      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.descripcion',
        'lotes.foto1',
        'lotes.estado as lote_estado',
        'contrato_lotes.precio_base',
        'contrato_lotes.moneda_id',
        'contratos.subasta_id',
        'subastas.estado as subasta_estado',
        'subastas.fecha_inicio',
        'subastas.fecha_fin'
      )
      ->selectRaw('COALESCE(p.monto, 0) as puja_actual')
      ->selectRaw('CASE WHEN p.id IS NULL THEN 0 ELSE 1 END as tiene_pujas')

      ->distinct();

    // 👉 paginación SIEMPRE acá
    return $query->simplePaginate(
      $perPage,
      ['*'],
      'page',
      $page
    );
  }

















  private const MAP_ACTIVOS = [
    'pujas' => true,
    'estado_lote' => true,
    'tiempo' => true,
  ];

  private const MAP_PROXIMOS = [
    // nada de pujas
    'estado_lote' => true,
  ];

  private const MAP_PASADOS = [
    'estado_lote' => true,
  ];

  private const MAP_FOTOS = [];




  private function mapLote(
    $lote,
    // Subasta $subasta,
    array $options = []
  ): array {
    return array_filter([
      'id' => $lote->id,
      'titulo' => $lote->titulo,
      'foto' => $lote->foto1,
      'descripcion' => $options['descripcion'] ?? false
        ? $lote->descripcion
        : null,

      'precio_base' => $lote->precio_base,
      'moneda_id'   => $lote->moneda_id,

      // 🔥 SOLO SI SE PIDE
      'puja_actual' => ($options['pujas'] ?? false)
        ? $lote->pujas->first()?->monto
        : null,


      'tienePujas' => ($options['pujas'] ?? false)
        ? $lote->pujas->isNotEmpty()
        : null,






      'estado_lote' => $options['estado_lote'] ?? false
        ? $lote->lote_estado
        : null,

      'tiempo_post_subasta_fin' => $options['tiempo'] ?? false
        ? $lote->tiempo_post_subasta_fin
        : null,
    ], fn($v) => !is_null($v));
  }



  public function getLotesActivosDestacados(Subasta $subasta)
  {
    if (! $subasta->isActiva()) {
      throw new \Exception('Subasta no activa', 403);
    }

    return $subasta
      ->lotesActivosDestacados()
      // 👇 SOLO porque es ACTIVA y se muestran pujas
      ->with([
        'pujas' => function ($q) {
          $q->select('id', 'lote_id', 'monto')
            ->latest('id')
            ->limit(1);
        }
      ])
      ->get()
      ->map(fn($lote) => $this->mapLote(
        $lote,
        self::MAP_ACTIVOS   // 👈 perfil ACTIVO
      ));
  }


  public function getLotesProximosDestacados(Subasta $subasta)
  {
    if (! $subasta->isProxima()) {
      throw new \Exception('Subasta no disponible', 403);
    }

    return $subasta
      ->lotesProximosDestacados()
      // 🚫 NO cargamos pujas (no se usan en próximos)
      ->get()
      ->map(fn($lote) => $this->mapLote(
        $lote,
        self::MAP_PROXIMOS   // 👈 perfil PROXIMO
      ));
  }



  // public function getLotesProximosDestacados(Subasta $subasta)
  // {
  //   return $this->getDestacados(
  //     $subasta,
  //     fn($s) => $s->isProxima(),
  //     fn($s) => $s->lotesProximosDestacados()
  //   );
  // }

  // public function getLotesPasadosDestacados(Subasta $subasta)
  // {
  //   return $this->getDestacados(
  //     $subasta,
  //     fn($s) => $s->isPasada(),
  //     fn($s) => $s->lotesPasadosDestacados()
  //   );
  // }




  public function activas(): Collection
  {
    $subastas = Subasta::whereIn('estado', ['activa', 'enpuja'])->get();

    $lotes = $this->lotesPorSubasta(
      $subastas->pluck('id'),
      function ($q) {
        $q->where('lotes.estado', LotesEstados::EN_SUBASTA)
          ->where('contrato_lotes.estado', 'activo')
          ->where('lotes.destacado', true)
          ->where(function ($q) {
            $q->whereNull('contrato_lotes.tiempo_post_subasta_fin')
              ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '>=', now());
          });
      }
    );

    return $this->armarRespuesta($subastas, $lotes);
  }

  public function proximas(): Collection
  {
    $subastas = Subasta::where('fecha_inicio', '>', Carbon::now())->get();

    $lotes = $this->lotesPorSubasta(
      $subastas->pluck('id'),
      fn($q) =>
      $q->where('lotes.estado', LotesEstados::ASIGNADO)
        ->where('contrato_lotes.estado', 'activo')
        ->where('lotes.destacado', true)
    );

    return $this->armarRespuesta($subastas, $lotes);
  }

  public function finalizadas(): Collection
  {
    $subastas = Subasta::where('estado', 'finalizada')->get();

    $lotes = $this->lotesPorSubasta(
      $subastas->pluck('id'),
      fn($q) =>
      $q->whereIn('lotes.estado', [
        LotesEstados::VENDIDO,
        LotesEstados::DEVUELTO,
        LotesEstados::STANDBY,
        LotesEstados::DISPONIBLE,
      ])
        ->where('lotes.destacado', true)
    );

    return $this->armarRespuesta($subastas, $lotes);
  }

  /* ================= HELPERS ================= */

  private function lotesPorSubasta($subastaIds, callable $callback)
  {
    return Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->whereIn('contratos.subasta_id', $subastaIds)
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'contratos.subasta_id'
      )
      ->tap($callback)
      ->get()
      ->groupBy('subasta_id');
  }

  private function armarRespuesta($subastas, $lotes)
  {

    return $subastas->map(
      fn($sub) => new SubastasDTO(
        $sub,
        $lotes[$sub->id] ?? collect()
      )
    );
  }
}
