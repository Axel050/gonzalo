<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;

    protected $fillable = [
        'motivo_id',
        'lote_id',
        'fecha',
        'descripcion',
        'estado',
    ];

    public function motivo()
    {
        return $this->belongsTo(MotivoDevolucion::class, 'motivo_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'devolucion_lotes', 'devolucion_id', 'lote_id')
            ->withTimestamps();
    }
}
