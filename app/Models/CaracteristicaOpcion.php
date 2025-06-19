<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracteristicaOpcion extends Model
{
  use HasFactory;


  protected $table = "caracteristica_opciones";
  protected $fillable = ['caracteristica_id', 'valor'];

  public function caracteristica()
  {
    return $this->belongsTo(Caracteristica::class);
  }
}
