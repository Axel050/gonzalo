<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadosAdquirente extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'nombre',
    'descripcion'
  ];

  public function adquirentes()
  {
    return $this->hasMany(Adquirente::class, 'estado_id');
  }
}
