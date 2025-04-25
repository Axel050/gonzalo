<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComitentesAlias extends Model
{

  protected $fillable = ["nombre", "comitente_id"];


  public function comitente()
  {
    return $this->belongsTo(Comitente::class);
  }

  public function comitentes()
  {
    return $this->hasMany(Comitente::class, "alias_id")->count();
  }
}
