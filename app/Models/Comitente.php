<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comitente extends Model
{
  use HasFactory;

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
}
