<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdquirentesAlias extends Model
{

  protected $fillable = ["nombre", "adquirente_id"];


  public function adquirente()
  {
    return $this->belongsTo(Adquirente::class);
  }

  public function adquirentes()
  {
    return $this->hasMany(Adquirente::class, "alias_id")->count();
  }
}
