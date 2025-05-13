<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
  use HasFactory;

  protected $fillable = [
    'nombre',
    'tipo',
  ];

  // public function tiposBiens()
  // {
  //   return $this->belongsToMany(TiposBien::class, 'tipo_bien_caracteristicas')
  //     // ->withPivot('requerido')
  //     ->withTimestamps();
  // }
}
