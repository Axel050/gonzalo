<?php

namespace App\Models;

use App\Enums\OrdenesEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
  use HasFactory;

  protected $fillable = ['adquirente_id', 'total', 'descuento', 'estado', 'payment_id', 'fecha_pago', 'subasta_id'];

  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }

  public function subasta()
  {
    return $this->belongsTo(Subasta::class);
  }

  public function lotes()
  {
    return $this->hasMany(OrdenLote::class);
  }

  public function getTotalNetoAttribute(): float
  {
    return $this->total - $this->descuento;
  }

  // $ordenes = Orden::byEstado(OrdenesEstados::PENDIENTE)
  public function scopeByEstado($query, string $estado)
  {
    return $query->where('estado', $estado);
  }

  public function getEstadoLabelAttribute(): string
  {
    return OrdenesEstados::getLabel($this->estado);
  }
}
