<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
  use HasFactory;

  protected $fillable = ['adquirente_id', 'estado'];

  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }

  public function carritoLotes()
  {
    return $this->hasMany(CarritoLote::class);
  }

  public function lotes()
  {
    return $this->belongsToMany(Lote::class, 'carrito_lotes')
      ->withPivot('subasta_id')
      ->withTimestamps();
  }
}
