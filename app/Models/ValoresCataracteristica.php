<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValoresCataracteristica extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $guarded = [];

  // Relación con caracteristicas
  public function caracteristica()
  {
    return $this->belongsTo(Caracteristica::class, 'caracteristica_id');
  }

  public function lote()
  {
    return $this->belongsTo(Lote::class);
  }
}
