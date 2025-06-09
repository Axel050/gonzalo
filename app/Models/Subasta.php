<?php

namespace App\Models;


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
    'descripcion'
  ];



  // Relación con Lote a través de LoteSubasta
  public function lotes2()
  {
    return $this->belongsToMany(Lote::class, 'lote_subastas', 'subasta_id', 'lote_id')
      ->withPivot([
        'contrato_id',
        'precio_base',
        'adquirente_id',
        'precio_final',
        'estado'
      ]);
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
}
