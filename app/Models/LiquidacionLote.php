<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiquidacionLote extends Model
{
    use HasFactory;

    protected $fillable = [
        'liquidacion_id',
        'lote_id',
        'subasta_id',
        'tipo',
        'concepto',
        'monto'
    ];

    public function liquidacion()
    {
        return $this->belongsTo(Liquidacion::class);
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function subasta()
    {
        return $this->belongsTo(Subasta::class);
    }
}
