<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CondicionIva extends Model
{
  use HasFactory;

  protected $fillable = [
    'nombre',
  ];

  public function adquirentes()
  {
    return $this->hasMany(Adquirente::class, 'condicion_iva_id');
  }
}
