<?php

namespace App\Models;

use App\Enums\OrdenesEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Orden extends Model implements Auditable
{
  use HasFactory;
  use SoftDeletes;
  use \OwenIt\Auditing\Auditable;


  protected $fillable = ['adquirente_id', 'total', 'descuento', 'estado', 'payment_id', 'fecha_pago', 'subasta_id', 'monto_envio', 'envio_check', 'motivo', 'otro'];

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


  public function getSubtotalAttribute()
  {
    return $this->lotes()->sum('precio_final');
  }

  public function getTotalFinalAttribute()
  {
    return $this->subtotal + ($this->monto_envio ?? 0) - ($this->descuento ?? 0);
  }
}
