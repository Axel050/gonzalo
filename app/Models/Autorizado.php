<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizado extends Model
{
    use HasFactory;

      protected $fillable = [
        'nombre', 'apellido',  'email', 'telefono', 'dni' ,'comitente_id','adquirente_id'
    ];
}
