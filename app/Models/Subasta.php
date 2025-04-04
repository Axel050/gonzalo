<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Subasta extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
     use \OwenIt\Auditing\Auditable;

      protected $fillable = [
        'numero_subasta', 'titulo', 'comision', 'fecha_inicio', 
        'fecha_fin', 'tiempo_post_subasta', 'estado','descripcion'
    ];


      // Relación con Lote a través de LoteSubasta
    public function lotes()
    {
        return $this->belongsToMany(Lote::class, 'lote_subastas', 'subasta_id', 'lote_id')
                    ->withPivot([
                        'contrato_id', 'precio_base', 'adquirente_id', 
                        'precio_final', 'estado'
                    ]);
    }

        
}
