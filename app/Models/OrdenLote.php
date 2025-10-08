<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenLote extends Model
{
  use HasFactory;

  protected $fillable = ['orden_id', 'lote_id', 'subasta_id', 'precio_final'];

  public function orden()
  {
    return $this->belongsTo(Orden::class);
  }

  public function lote()
  {
    return $this->belongsTo(Lote::class);
  }
}
