<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class OrdenLote extends Model implements Auditable
{
  use HasFactory;
  use SoftDeletes;
  use \OwenIt\Auditing\Auditable;

  protected $fillable = ['orden_id', 'lote_id', 'precio_final'];

  public function orden()
  {
    return $this->belongsTo(Orden::class);
  }

  public function lote()
  {
    return $this->belongsTo(Lote::class);
  }
}
