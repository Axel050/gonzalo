<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoLote extends Model
{
  use HasFactory;

  protected $fillable = ['contrato_id', 'lote_id', 'precio_base', 'moneda_id', 'tiempo_post_subasta_fin'];

  // Relación con Contrato
  public function contrato()
  {
    return $this->belongsTo(Contrato::class);
  }

  // Relación con Lote
  public function lote()
  {
    return $this->belongsTo(Lote::class);
  }

  public function moneda()
  {
    return $this->belongsTo(Moneda::class);
  }

  public function pujas()
  {
    return $this->hasMany(Puja::class, "lote_id", $this->lote_id);
  }

  public function isActivo()
  {
    $now = now();
    return $this->estado === 'activo' &&
      ($this->tiempo_post_subasta_fin === null || $now->lte($this->tiempo_post_subasta_fin));
  }
}
