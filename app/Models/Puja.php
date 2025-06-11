<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puja extends Model
{
  use HasFactory;


  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }
}
