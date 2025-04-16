<?php

namespace App\Models;

use Database\Seeders\TipoBienCaracteristicaSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TiposBien extends Model
{
    use HasFactory;

    protected $fillable = [
      "nombre","suplente_id","encargado_id"
    ];

    public function tbcaracteristicas(): BelongsToMany
{
    return $this->belongsToMany(Caracteristica::class, 'tipo_bien_caracteristicas', 
                              'tipo_bien_id', // Foreign key on tipo_bien_caracteristicas table
                              'caracteristica_id') // Foreign key on caracteristicas table
                            ->withPivot('requerido')
                            ->withTimestamps()
                            ->whereNull('tipo_bien_caracteristicas.deleted_at');
}


      public function encargado(){
              return $this->belongsTo(Personal::class, "encargado_id");
    }

      public function suplente(){
              return $this->belongsTo(Personal::class, "suplente_id");
    }

    //   public function caracteristicas(){
    //           return $this->hasMany(TipoBienCataracteristica::class,"tipo_bien_id");
    // }

}
