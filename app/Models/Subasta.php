<?php

namespace App\Models;

use App\Enums\LotesEstados;
use App\Enums\SubastaEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Subasta extends Model implements Auditable
{
  use HasFactory, SoftDeletes;
  use \OwenIt\Auditing\Auditable;

  protected $fillable = [
    'numero_subasta',
    'titulo',
    'comision',
    'fecha_inicio',
    'fecha_fin',
    'tiempo_post_subasta',
    'estado',
    'descripcion',
    'garantia',
    'envio',
    'desc_extra',
    'garantias_notificadas_at'
  ];

  protected $casts = [
    'fecha_fin' => 'datetime',
    'fecha_inicio' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
  ];





  public function depositos()
  {
    return $this->hasMany(Garantia::class);
  }

  public function pujas()
  {
    return $this->hasMany(Puja::class, "subasta_id");
  }




  public function contratos()
  {
    return $this->hasMany(Contrato::class, 'subasta_id');
  }

  // Relación con lotes a través de contratos
  public function lotes()
  {
    return $this->hasManyThrough(
      Lote::class,
      Contrato::class,
      'subasta_id', // Clave foránea en la tabla contratos
      'ultimo_contrato', // Clave foránea en la tabla lotes
      'id', // Clave primaria en subastas
      'id' // Clave primaria en contratos
    );
  }

  // Método para contar los lotes
  public function contarLotes()
  {
    return $this->lotes()->count();
  }



  // New7-4
  // info(["ContratosS" => $this->contratos->toArray()]);
  public function lotesActivosDestacados()
  {
    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
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
        'lotes.descripcion',
        'lotes.valuacion',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.tiempo_post_subasta_fin',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',
      );

    try {
      // $results = $query->get();
    } catch (\Exception $e) {
      info(["Error en lotesDestacados" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }

  public function lotesActivosDestacadosFoto()
  {
    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
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
      );

    try {
      $results = $query->get();
    } catch (\Exception $e) {
      info(["Error en lotesDestacados" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }




  public function lotesActivos()
  {


    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      ->where('lotes.estado', LotesEstados::EN_SUBASTA)
      ->where('contrato_lotes.estado', 'activo')
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->where(function ($query) {
        $query
          ->whereNull('contrato_lotes.tiempo_post_subasta_fin')
          // ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '>=', now()->subMinute());
          ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '>=', now());
      })
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.descripcion',
        'lotes.valuacion',
        'lotes.tipo_bien_id',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.tiempo_post_subasta_fin',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',

      );


    return $query;
  }

  public function isActivaCarrito()
  {
    $now = now();


    if ($this->estado === SubastaEstados::ACTIVA && $now->between($this->fecha_inicio, $this->fecha_fin)) {
      return true;
    }

    if ($this->estado === SubastaEstados::ENPUJA) {
      // return true;
    }

    return false;
  }


  public function isActiva()
  {
    $now = now();


    if ($this->estado === SubastaEstados::ACTIVA && $now->between($this->fecha_inicio, $this->fecha_fin)) {
      return true;
    }

    if ($this->estado === SubastaEstados::ENPUJA) {
      return true;
    }

    if ($this->estado === SubastaEstados::PAUSADA) {
      return false;
    }

    return $this->lotesActivos()->exists();
  }





  public function lotesProximos()
  {

    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      ->where('lotes.estado', LotesEstados::ASIGNADO)
      ->where('contrato_lotes.estado', 'activo')
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.descripcion',
        'lotes.valuacion',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',

      );

    try {
      // $results = $query->get();
      // info(["Lotes activoss" => $results->toArray()]);
    } catch (\Exception $e) {
      info(["Error en lotesProximos" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }

  public function lotesProximosDestacados()
  {

    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      ->where('lotes.estado', LotesEstados::ASIGNADO)
      ->where('contrato_lotes.estado', 'activo')
      ->where('lotes.destacado', true) // Filtro añadido
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.descripcion',
        'lotes.valuacion',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',

      );

    try {
      $results = $query->get();
      // info(["Lotes activoss" => $results->toArray()]);
    } catch (\Exception $e) {
      info(["Error en lotesProximos" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }


  public function lotesProximosDestacadosFoto()
  {

    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      ->where('lotes.estado', LotesEstados::ASIGNADO)
      ->where('contrato_lotes.estado', 'activo')
      ->where('lotes.destacado', true) // Filtro añadido
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.ultimo_contrato',
      );

    try {
      $results = $query->get();
      // info(["Lotes activoss" => $results->toArray()]);
    } catch (\Exception $e) {
      info(["Error en lotesProximos" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }




  public function isProxima()
  {
    $now = now();


    if ($this->estado === SubastaEstados::INACTIVA && $now->lessThan($this->fecha_inicio)) {
      return true;
    }


    if ($this->estado === SubastaEstados::PAUSADA) {
      return false;
    }


    return $this->lotesProximos()->exists();
  }



  public function lotesPasados()
  {
    info("AGREGAR ESTADO FINALIZADO A ESTADO LOTE ");
    info("llllllllllllll");
    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      // ->where('lotes.ultimo_contrato', 'contratos.id')
      ->whereColumn('contratos.id', 'lotes.ultimo_contrato')
      ->whereIn('lotes.estado', [
        LotesEstados::VENDIDO,
        LotesEstados::DEVUELTO,
        LotesEstados::STANDBY,
        LotesEstados::DISPONIBLE
      ])
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      // ->where('contrato_lotes.estado', 'activo')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.descripcion',
        'lotes.valuacion',
        'lotes.ultimo_contrato',
        'lotes.estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',
      );

    try {
      // $results = $query->get();
      // info(["123456789" => $results]);
    } catch (\Exception $e) {
      info(["Error en lotesPasados" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }

  public function lotesPasadosDestacados()
  {
    info("AGREGAR ESTADO FINALIZADO A ESTADO LOTE ");

    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      // ->where('lotes.ultimo_contrato', 'contratos.id')
      ->whereColumn('contratos.id', 'lotes.ultimo_contrato')
      ->whereIn('lotes.estado', [
        LotesEstados::VENDIDO,
        LotesEstados::DEVUELTO,
        LotesEstados::STANDBY,
        LotesEstados::DISPONIBLE
      ])
      ->where('lotes.destacado', true) // Filtro añadido
      ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
      );

    try {
      $results = $query->get();
      // info(["LotesPasadosDestacados" => $results]);
    } catch (\Exception $e) {
      info(["Error en lotesPasados" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }

  public function lotesPasadosDestacadosFoto()
  {
    info("AGREGAR ESTADO FINALIZADO A ESTADO LOTE ");

    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      // ->where('lotes.ultimo_contrato', 'contratos.id')
      ->whereColumn('contratos.id', 'lotes.ultimo_contrato')
      ->whereIn('lotes.estado', [
        LotesEstados::VENDIDO,
        LotesEstados::DEVUELTO,
        LotesEstados::STANDBY,
        LotesEstados::DISPONIBLE
      ])
      ->where('lotes.destacado', true) // Filtro añadido
      // ->where('contrato_lotes.estado', 'activo')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.descripcion',
        'lotes.valuacion',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',
      );

    try {
      $results = $query->get();
      // info(["LotesPasadosDestacados" => $results]);
    } catch (\Exception $e) {
      info(["Error en lotesPasados" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }



  public function lotesPasados2()
  {

    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      ->whereIn('lotes.estado', [
        LotesEstados::VENDIDO,
        LotesEstados::DEVUELTO,
        LotesEstados::STANDBY,
        LotesEstados::DISPONIBLE
      ])
      ->where('contrato_lotes.estado', 'activo')
      ->select(
        'lotes.id',
        'lotes.titulo',
        'lotes.foto1',
        'lotes.descripcion',
        'lotes.valuacion',
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.moneda_id',
        'contrato_lotes.precio_base',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',
      );

    try {
      $results = $query->get();
      info(["Lotes activoss" => $results->toArray()]);
    } catch (\Exception $e) {
      info(["Error en lotesPasados" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }




  public function isPasada()
  {
    $now = now();


    if ($this->estado === SubastaEstados::FINALIZADA && $now->greaterThan($this->fecha_fin)) {
      return true;
    }


    if ($this->estado === SubastaEstados::PAUSADA) {
      return false;
    }


    return $this->lotesPasados()->exists();
  }



  public function scopeProximas($q)
  {
    return $q->where('fecha_inicio', '>=', now());
  }

  public function scopeFinalizadas($q)
  {
    return $q->where('estado', 'finalizada');
  }

  public function scopeAbiertas($q)
  {
    return $q->whereIn('estado', ['activa', 'enpuja']);
  }

  public function scopeProximasDesc($q)
  {
    return $q
      ->where('fecha_inicio', '>=', now())
      ->orderBy('id', 'desc');
  }

  public function scopeFinalizadasDesc($q)
  {
    return $q
      ->where('estado', 'finalizada')
      ->orderBy('id', 'desc');
  }

  public function scopeAbiertasDesc($q)
  {
    return $q
      ->whereIn('estado', ['activa', 'enpuja'])
      ->orderBy('id', 'desc');
  }

  public function getFechaInicioHumanaAttribute(): ?string
  {
    if (!$this->fecha_inicio) return null;

    return sprintf(
      '%s de %s | %shs',
      $this->fecha_inicio->translatedFormat('d'),
      strtoupper($this->fecha_inicio->translatedFormat('M')),
      $this->fecha_inicio->format('H')
    );
  }

  public function getFechaFinHumanaAttribute(): ?string
  {
    if (!$this->fecha_fin) return null;

    return sprintf(
      '%s de %s | %shs',
      $this->fecha_fin->translatedFormat('d'),
      strtoupper($this->fecha_fin->translatedFormat('M')),
      $this->fecha_fin->format('H')
    );
  }
}
