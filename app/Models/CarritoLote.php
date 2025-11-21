<?php

namespace App\Models;

use App\Enums\CarritoLoteEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CarritoLote extends Model
{
  use HasFactory;

  protected $table = 'carrito_lotes';
  // protected $fillable = ['carrito_id', 'lote_id', 'subasta_id'];

  protected $fillable = ['carrito_id', 'lote_id', 'subasta_id', 'estado'];


  // DEFAULT sino se asigna estado se crea activo
  protected $attributes = [
    'estado' => CarritoLoteEstados::ACTIVO,
  ];


  /** Scopes útiles **/
  public function scopeActivos($query)
  {
    return $query->where('estado', CarritoLoteEstados::ACTIVO);
  }

  public function scopeAdjudicados($query)
  {
    return $query->where('estado', CarritoLoteEstados::ADJUDICADO);
  }

  public function scopeEnOrden($query)
  {
    return $query->where('estado', CarritoLoteEstados::EN_ORDEN);
  }

  /** Helper para mostrar etiqueta **/
  public function getEstadoLabelAttribute()
  {
    return CarritoLoteEstados::getLabel($this->estado);
  }

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
