<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class Garantia extends Model implements Auditable
{
  use HasFactory, SoftDeletes;
  use \OwenIt\Auditing\Auditable;

  protected $table = "depositos";
  protected $fillable = ["subasta_id", "adquirente_id", "monto", "estado", "fecha", "fecha_devolucion", "payment_id"];

  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }

  public function subasta()
  {
    return $this->belongsTo(Subasta::class);
  }

  public function scopePagada($query)
  {
    return $query->where('estado', "pagado");
  }
}
