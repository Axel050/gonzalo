<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Contrato extends Model implements Auditable
{
  use HasFactory;
  use SoftDeletes;
  use \OwenIt\Auditing\Auditable;

  protected $fillable = [
    'archivo_path',
    'descripcion',
    'fecha_firma',
    'comitente_id',
    'subasta_id'
  ];

  // Relación con Comitente
  public function comitente()
  {
    return $this->belongsTo(Comitente::class);
  }

  public function subasta()
  {
    return $this->belongsTo(Subasta::class);
  }

  // Relación con Lote a través de ContratoLotes
  public function lotes()
  {
    return $this->belongsToMany(Lote::class, 'contrato_lotes', 'contrato_id', 'lote_id')
      ->withPivot('precio_base')
      ->wherePivotNull('deleted_at');
  }

  public function contratoLotes()
  {
    return $this->hasMany(ContratoLote::class);
  }


  public function puedeCambiarSubasta(): ?string
  {
    $loteIds = $this->contratoLotes()->pluck('lote_id');

    if ($loteIds->isEmpty()) {
      return null;
    }

    if (Puja::whereIn('lote_id', $loteIds)->exists()) {
      return 'PUJAS';
    }

    if (CarritoLote::whereIn('lote_id', $loteIds)->exists()) {
      return 'CARRITO';
    }

    if (OrdenLote::whereIn('lote_id', $loteIds)->exists()) {
      return 'ORDEN';
    }

    return null;
  }
}
