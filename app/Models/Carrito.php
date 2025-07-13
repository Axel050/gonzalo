<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
  use HasFactory;

  protected $fillable = ["adquirente_id", "subasta_id"];


  public function carritioLotes()
  {
    return $this->hasMany(CarritoLote::class);
  }
}
