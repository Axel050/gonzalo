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
      ->withTimestamps()

      // 1. Ordena los estados:
      //    Prioriza ACTIVO (aparece primero con un valor 0),
      //    y luego CERRADO, ADJUDICADO, EN_ORDEN (con un valor 1).
      //    El '0' va antes que el '1' por defecto.
      ->orderByRaw(
        "
        CASE 
                WHEN carrito_lotes.estado = ? THEN 0              /* ACTIVO (primero) */
                WHEN carrito_lotes.estado = ? THEN 2              /* EN_ORDEN (segundo) */
                ELSE 1                                            /* ADJUDICADO o CERRADO (tercero/final) */
            END ASC",
        [
          CarritoLoteEstados::ACTIVO,
          CarritoLoteEstados::EN_ORDEN
        ]
      )

      // 2. Ordena por el ID de la tabla pivote de forma descendente.
      //    Asegúrate de especificar el nombre completo de la columna: 'carrito_lotes.id'
      ->orderBy('carrito_lotes.id', 'DESC');
  }
}
