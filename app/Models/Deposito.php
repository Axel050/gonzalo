<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
  use HasFactory;

  protected $fillable = ["subasta_id", "adquirente_id", "monto", "estado", "fecha", "fecha_devolucion"];

  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }

  public function subasta()
  {
    return $this->belongsTo(Subasta::class);
  }
}
