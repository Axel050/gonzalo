<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    
       protected $fillable = [
        'archivo_path', 'descripcion', 'fecha_firma', 'comitente_id'
    ];

    // Relación con Comitente
    public function comitente()
    {
        return $this->belongsTo(Comitente::class);
    }

    // Relación con Lote a través de ContratoLotes
    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'contrato_lotes', 'contrato_id', 'lote_id')
                    ->withPivot('precio_base'); // Incluir el campo adicional de la tabla pivote
    }
}
