<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
  use HasFactory;

  protected $fillable = [
    'numero',
    'fecha',
    'nombre',
    'apellido',
    'cuit',
    'dni',
    'direccion',
    'email',
    'tipo',
    'estado',
    'condicion_iva',
    'comision_subasta',
    'iva_subasta',
    'observaciones',
    'fecha_pago',
    'estado_pago',
    'adquirente_id',
    'orden_id',
    // Nuevos campos
    'tipo_comprobante',
    'tipo_concepto',
    'punto_venta',
    'cae',
    'vto_cae',
    'monto_total',
    'factura_asociada_id'
  ];


  public function orden()
  {
    return $this->belongsTo(Orden::class);
  }

  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }

  public function items()
  {
    return $this->hasMany(FacturaLote::class);
  }

  public function facturaAsociada()
  {
    return $this->belongsTo(Factura::class, 'factura_asociada_id');
  }
}
