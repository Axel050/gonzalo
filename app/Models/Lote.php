<?php

namespace App\Models;

use App\Enums\LotesEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Lote extends Model implements Auditable
{
  use HasFactory;
  use SoftDeletes;
  use \OwenIt\Auditing\Auditable;


  protected $fillable = [
    'titulo',
    'descripcion',
    'valuacion',
    'foto1',
    'foto2',
    'foto3',
    'foto4',
    'fraccion_min',
    'venta_directa',
    'precio_venta_directa',
    'tipo_bien_id',
    'estado',
    'comitente_id',
    'ultimo_contrato',
    "destacado",
    'desc_extra'
  ];

  public function valoresCaracteristicas()
  {
    return $this->hasMany(ValoresCataracteristica::class, 'lote_id');
  }


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




  public function contratosLotes()
  {
    return $this->hasMany(ContratoLote::class, 'lote_id');
  }

  // Relación con Contrato a través de ContratoLotes
  public function contratos()
  {
    return $this->belongsToMany(Contrato::class, 'contrato_lotes', 'lote_id', 'contrato_id')
      ->withPivot('precio_base'); // Incluir el campo adicional de la tabla pivote
  }


  public function ultimoContrato()
  {
    return $this->belongsTo(Contrato::class, 'ultimo_contrato');
  }



  public function getMonedaAttribute()
  {
    if ($this->ultimo_contrato) {
      return $this->contratoLotes()
        ->where('contrato_id', $this->ultimo_contrato)
        ->value('moneda_id');
    }
    return null; // Return null if no ultimo_contrato is set

  }


  public function getPrecioBaseAttribute()
  {
    if ($this->ultimo_contrato) {
      return $this->contratoLotes()
        ->where('contrato_id', $this->ultimo_contrato)
        ->value('precio_base');
    }
    return null; // Return null if no ultimo_contrato is set
  }


  public function getPrecioFinalAttribute()
  {
    $pujaFinal = $this->getPujaFinal();
    return $pujaFinal ? $pujaFinal->monto : 0;
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

  public function comitente()
  {
    return $this->belongsTo(Comitente::class);
  }

  public function tipo()
  {
    return $this->belongsTo(TiposBien::class, "tipo_bien_id");
  }



  public function contratoLotes()
  {
    return $this->hasMany(ContratoLote::class);
  }

  public function ultimoContratoLote22()
  {
    // return $this->hasOne(ContratoLote::class)->latestOfMany();
  }



  public function ultimoConLote()
  {
    return $this->hasOne(ContratoLote::class, 'lote_id')
      ->where('contrato_id', $this->ultimo_contrato);
  }


  public function pujas()
  {
    return $this->hasMany(Puja::class)->orderBy('id', 'desc');;
  }

  public function getPujaFinal()
  {
    return $this->pujas()->orderByDesc('id')->first();
  }

  // New7-4
  public function isActivoEnSubasta($subastaId)
  {
    $contratoLote = $this->contratoLotes()
      ->whereHas('contrato', function ($query) use ($subastaId) {
        $query->where('subasta_id', $subastaId);
      })
      ->first();

    if (!$contratoLote) {
      return false;
    }

    return $contratoLote->isActivo();
  }


  public function getMontoActualAttribute()
  {
    return optional($this->getPujaFinal())->monto ?? 0;
  }

  public function getMonedaSignoAttribute()
  {
    // Si ya tenés relación con Moneda, usala:
    $moneda = Moneda::find($this->moneda);
    return $moneda?->signo ?? '';
  }
}
