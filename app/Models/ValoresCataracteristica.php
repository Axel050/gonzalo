<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoresCataracteristica extends Model
{
  use HasFactory;

  protected $guarded = [];

  // Relación con caracteristicas
  public function caracteristica()
  {
    return $this->belongsTo(Caracteristica::class, 'caracteristica_id');
  }
}
