<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoLote extends Model
{
  use HasFactory;

  protected $fillable = ["carrito_id", "lote_id", "ultima_oferta"];
}
