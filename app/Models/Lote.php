<?php

namespace App\Models;

use App\Enums\LotesEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
  use HasFactory;


  protected $fillable = [
    'titulo',
    'descripcion',
    'valuacion',
    'foto_front',
    'foto_back',
    'foto_add_1',
    'fraccion_min',
    'venta_directa',
    'precio_venta_directa',
    'tipo_bien_id',
    'estado_id',
    'moneda_id'
  ];

  /* Validar si un estado es válido.
     */
  public static function isValidEstado(string $estado): bool
  {
    return in_array($estado, LotesEstados::all());
  }

  /**
   * Scope para filtrar por estado.
   */
  public function scopeByEstado($query, string $estado)
  {
    return $query->where('estado', $estado);
  }

  /**
   * Obtener el nombre legible del estado.
   */
  public function getEstadoLabelAttribute(): string
  {
    return LotesEstados::getLabel($this->estado);
  }



  // Relación con Contrato a través de ContratoLotes
  public function contratos()
  {
    return $this->belongsToMany(Contrato::class, 'contrato_lotes', 'lote_id', 'contrato_id')
      ->withPivot('precio_base'); // Incluir el campo adicional de la tabla pivote
  }

  // Relación con Subasta a través de LoteSubasta
  public function subastas()
  {
    return $this->belongsToMany(Subasta::class, 'lote_subastas', 'lote_id', 'subasta_id')
      ->withPivot([
        'contrato_id',
        'precio_base',
        'adquirente_id',
        'precio_final',
        'estado'
      ]);
  }
}
