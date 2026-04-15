<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'fecha',
        'estado',
        'comitente_id',
        'observaciones',
        'monto_total',
        'subtotal_lotes',
        'subtotal_comisiones',
        'subtotal_gastos',
        'comision_porcentaje',
        'liquidacion_asociada_id',
        'tipo_concepto',
    ];

    protected $casts = [
        'comision_porcentaje' => 'integer',
    ];

    public function comitente()
    {
        return $this->belongsTo(Comitente::class);
    }

    public function items()
    {
        return $this->hasMany(LiquidacionLote::class);
    }

    public function asociadas()
    {
        return $this->hasMany(Liquidacion::class, 'liquidacion_asociada_id');
    }

    public function asociadaDe()
    {
        return $this->belongsTo(Liquidacion::class, 'liquidacion_asociada_id');
    }
}
