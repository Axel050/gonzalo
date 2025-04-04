<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoLote extends Model
{
  use HasFactory;

     protected $fillable = ['contrato_id', 'lote_id', 'precio_base'];

    // Relación con Contrato
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    // Relación con Lote
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }
}
