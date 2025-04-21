<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adquirente extends Model
{
  use HasFactory;


  protected $fillable = [
    'nombre',
    'apellido',
    'alias',
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
}
