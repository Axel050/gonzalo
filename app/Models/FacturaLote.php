<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaLote extends Model
{

  protected $fillable = [
    'precio',
    'factura_id',
    'lote_id',
    'subasta_id',
    'concepto'
  ];

  public function factura()
  {
    return $this->belongsTo(Factura::class);
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
