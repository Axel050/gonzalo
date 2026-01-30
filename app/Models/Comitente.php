<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Comitente extends Model implements Auditable
{
  use HasFactory, SoftDeletes;
  use \OwenIt\Auditing\Auditable;

  protected $fillable = [
    'nombre',
    'apellido',
    'alias',
    'mail',
    'telefono',
    'CUIT',
    'domicilio',
    'comision',
    'banco',
    'numero_cuenta',
    'CBU',
    'alias_bancario',
    'observaciones',
    'foto'
  ];


  public function autorizados()
  {
    return $this->hasMany(Autorizado::class);
  }

  public function contrato()
  {
    return $this->hasMany(Contrato::class);
  }

  public function alias()
  {
    return $this->belongsTo(ComitentesAlias::class, "alias_id");
  }



  // Relación con Lote a través de Contrato y ContratoLotes
  public function Clotes()
  {
    return $this->hasMany(Lote::class);
  }

  public function lotes()
  {
    return $this->hasManyThrough(
      Lote::class,        // Modelo final (Lote)
      Contrato::class,     // Modelo intermedio (Contrato)
      'comitente_id',      // Clave externa en Contrato que apunta a Comitente
      'id',               // Clave primaria en Lote
      'id',                // Clave primaria en Comitente
      'id'                 // Clave primaria en Contrato
    )->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->select('lotes.*');
  }


  public function getComisionFormateadaAttribute()
  {
    $number = $this->comision;

    $decimales = fmod($number, 1) == 0 ? 0 : 1;

    return number_format($number, $decimales, ',', "'");
  }
}
