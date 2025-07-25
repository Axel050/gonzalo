<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoLote extends Model
{
  use HasFactory;

  protected $table = 'carrito_lotes';
  protected $fillable = ['carrito_id', 'lote_id', 'subasta_id'];

  public function carrito()
  {
    return $this->belongsTo(Carrito::class);
  }

  public function lote()
  {
    return $this->belongsTo(Lote::class);
  }

  public function subasta()
  {
    return $this->belongsTo(Subasta::class);
  }
}
