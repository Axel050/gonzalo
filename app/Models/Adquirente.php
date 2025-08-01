<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Adquirente extends Model implements Auditable
{
  use HasFactory;
  use \OwenIt\Auditing\Auditable;

  protected $fillable = [
    'nombre',
    'apellido',
    'alias_id',
    'telefono',
    'CUIT',
    'domicilio',
    'comision',
    'estado_id',
    'condicion_iva_id',
    'user_id',
    'foto',
    'CBU',
    'numero_cuenta',
    'banco',
    'alias_bancario',
  ];



  public function carrito()
  {
    return $this->hasOne(Carrito::class);
  }

  public function autorizados()
  {
    return $this->hasMany(Autorizado::class);
  }


  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function alias()
  {
    return $this->belongsTo(AdquirentesAlias::class, "alias_id");
  }


  public function garantias()
  {
    return $this->hasMany(Garantia::class);
  }

  public function garantia(int $subasta_id): bool
  {
    return $this->garantias()
      ->where('subasta_id', $subasta_id)
      ->where('estado', 'pagado')
      ->exists();
  }
}
