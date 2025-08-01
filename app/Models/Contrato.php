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
      ->withPivot('precio_base'); // Incluir el campo adicional de la tabla pivote
  }
}
