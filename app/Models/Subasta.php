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
  ];

  protected $casts = [
    'fecha_fin' => 'datetime',
    'fecha_inicio' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'deleted_at' => 'datetime',
  ];





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
  public function lotesActivos()
  {

    // if (!$this->isActiva()) {
    //   return [];
    // }

    // info(["LOTESACTIVOS" => now()]);
    $query = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->where('contratos.subasta_id', $this->id)
      ->where('lotes.estado', LotesEstados::EN_SUBASTA)
      ->where('contrato_lotes.estado', 'activo')
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
        'lotes.ultimo_contrato',
        'lotes.estado as lote_estado',
        'contrato_lotes.precio_base',
        'contrato_lotes.tiempo_post_subasta_fin',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',

      )
      // ->with(['pujas' => function ($query) {
      //   $query->orderByDesc('id')->first();
      // }])
    ;

    // info(["test"]);
    try {
      $results = $query->get();
      // info(["Lotes activoss" => $results->toArray()]);
    } catch (\Exception $e) {
      info(["Error en lotesActivos" => $e->getMessage()]);
      throw $e;
    }

    return $query;
  }

  public function lotesActivos2()
  {
    info(["Contratos lotesacticoa" => $this->contratos->toArray()]);


    return $this->contratos()
      ->join('contrato_lotes', 'contratos.id', '=', 'contrato_lotes.contrato_id')
      ->join('lotes', 'contrato_lotes.lote_id', '=', 'lotes.id')
      ->where('contrato_lotes.estado', 'activo')
      // ->where(function ($query) {
      //   $query->whereNull('contrato_lotes.tiempo_post_subasta_fin')
      //     ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '>=', now());
      // })
      ->select('lotes.*', 'contrato_lotes.precio_base', 'contrato_lotes.tiempo_post_subasta_fin', 'contrato_lotes.estado')
      ->with(['pujas' => function ($query) {
        $query->orderByDesc('id')->first();
      }]);
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
}
