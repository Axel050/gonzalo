<?php

namespace App\Models;

use App\Enums\CarritoLoteEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Carrito extends Model
{
  use HasFactory;

  protected $fillable = ['adquirente_id'];

  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }

  public function carritoLotes()
  {
    return $this->hasMany(CarritoLote::class);
  }

  public function carritoLo()
  {
    return $this->hasMany(CarritoLote::class);
  }

  public function lotes()
  {
    return $this->belongsToMany(Lote::class, 'carrito_lotes')
      ->withPivot('subasta_id')
      ->withTimestamps();
  }

  // En el modelo Carrito
  public function lotesFiltrados()
  {
    return $this->belongsToMany(Lote::class, 'carrito_lotes')
      ->withPivot('subasta_id', 'estado')
      ->wherePivotIn('estado', [
        CarritoLoteEstados::ACTIVO,
        CarritoLoteEstados::ADJUDICADO,
        CarritoLoteEstados::EN_ORDEN,
        CarritoLoteEstados::CERRADO,

      ])
      ->withTimestamps();
  }
}
