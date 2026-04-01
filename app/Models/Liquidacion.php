<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
  use HasFactory;
  protected $fillable = [
    'numero',
    'fecha',
    'estado',
    'comitente_id',
    'observaciones',
    'monto_total',
    'subtotal_lotes',
    'subtotal_comisiones',
    'subtotal_gastos',
    'comision_porcentaje',
  ];

  public function comitente()
  {
    return $this->belongsTo(Comitente::class);
  }

  public function items()
  {
    return $this->hasMany(LiquidacionLote::class);
  }
}
