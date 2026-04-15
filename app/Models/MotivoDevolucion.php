<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivoDevolucion extends Model
{
  use HasFactory;

  protected $fillable = [
    'nombre',
    'descripcion',
  ];


  public function devoluciones()
  {
    return $this->hasMany(Devolucion::class, "motivo_id");
  }
}
