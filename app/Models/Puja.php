<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puja extends Model
{
  use HasFactory;

  protected $fillable = ['adquirente_id', 'lote_id', 'subasta_id', 'monto'];

  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }
}
