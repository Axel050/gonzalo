<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Personal extends Model
{
    use HasFactory;

      protected $fillable = [ 'nombre', 'apellido', 'alias' , 'telefono', 'CUIT', 'domicilio','role_id','user_id','foto'];
                                    


    public function user (){
        return $this->belongsTo(User::class);
    }

    public function role (){
        return $this->belongsTo(Role::class);
    }
}
