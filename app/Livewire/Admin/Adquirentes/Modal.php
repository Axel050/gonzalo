<?php

namespace App\Livewire\Admin\Adquirentes;

use App\Models\Adquirente;
use App\Models\Alias;
use App\Models\CondicionIva;
use App\Models\EstadosAdquirente;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Modal extends Component
{

  use WithFileUploads;

  public $existe = false;
  public $aliases;

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $adquirente;

  public $nombre, $apellido, $alias, $CUIT, $domicilio, $telefono, $mail, $banco, $numero_cuenta, $CBU, $alias_bancario, $foto, $estado_id;
  public $password, $password_confirmation;
  public $comision = 20;
  public $condicion_iva_id;
  public $estados = [];
  public $condiciones = [];
  public $ver = false;
  public $typePass = "password";

  public $autorizados;


  public function updatedVer()
  {
    $this->typePass = $this->ver ? "text" : "password";
  }



  protected function rules()
  {

    $rules = [
      'nombre' => 'required',
      'apellido' => 'required',
      'telefono' => 'required',
      'comision' => 'required|numeric|min:0',
      'condicion_iva_id' => 'required',
      'estado_id' => 'required',

      // 'foto' => 'required',                              
    ];
    if ($this->method == "update") {
      $rules["alias"] = 'required|unique:adquirentes,alias,' . $this->adquirente->id;
      $rules['mail'] = 'required|email|unique:users,email,' . $this->adquirente->user->id;

      if ($this->password || $this->password_confirmation) {
        $rules['password'] = 'required|string|confirmed|min:8';
      }
    } else {
      $rules["CUIT"] = 'required|unique:adquirentes,CUIT';
      $rules["alias"] = 'required|unique:adquirentes,alias';
      $rules['password'] = 'required|string|confirmed|min:8';
      $rules['mail'] = 'required|email|unique:users,email';
    }

    return $rules;
  }

  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "apellido.required" => "Ingrese  apellido.",
      "telefono.required" => "Ingrese  telefono.",
      "CUIT.required" => "Ingrese  CUIT.",
      "CUIT.unique" => "CUIT existente.",
      "alias.required" => "Ingrese alias .",
      "alias.unique" => "Alias existente.",
      "comision.required" => "Ingrese comision.",
      "comision.numeric" => "Comision invalida.",
      "comision.min" => "Comision invalida.",
      "condicion_iva_id.required" => "Elija condicion.",
      "estado_id.required" => "Elija estado.",
      "mail.required" => "Ingrese  mail.",
      "mail.email" => "Mail invalido.",
      "mail.unique" => "Mail existente.",
      "password.confirmed" => "Confirme contraseña.",
      "password.required" => "Ingrese contraseña.",
      "password.min" => "Minimo 8 caracteres.",
    ];
  }




  public function mount()
  {

    $this->aliases = Alias::all();

    $this->condiciones = CondicionIva::all();
    $this->estados = EstadosAdquirente::all();


    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->adquirente = Adquirente::find($this->id);
      $this->nombre = $this->adquirente->nombre;
      $this->apellido = $this->adquirente->apellido;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->adquirente = Adquirente::find($this->id);

      $this->nombre =  $this->adquirente->nombre;
      $this->apellido =  $this->adquirente->apellido;
      $this->alias =  $this->adquirente->alias;
      $this->mail =  $this->adquirente->user->email;
      $this->telefono =  $this->adquirente->telefono;
      $this->CUIT =  $this->adquirente->CUIT;
      $this->domicilio =  $this->adquirente->domicilio;
      $this->condicion_iva_id =  $this->adquirente->condicion_iva_id;
      $this->estado_id =  $this->adquirente->estado_id;
      $this->foto =  $this->adquirente->foto;

      if ($this->adquirente->comision !== null) {
        $comision = floatval($this->adquirente->comision);
        $comision = ($comision == floor($comision)) ? (int)$comision : $comision;
        $this->comision =  $comision;
      }



      if ($this->method == "update") {
        $this->title = "Editar";
        $this->bg = "background-color: rgb(234 88 12)";
        $this->btnText = "Guardar";
      } else {
        $this->title = "Ver";
        $this->bg =  "background-color: rgb(31, 83, 44)";
      }
      // $this->bg="background-color: rgb(234 88 12)";
    }
  }



  public function save()
  {
    // VER ESTADO_ID PARA AGREGAR ROLE LUEGO
    $this->validate();


    $filename = '';

    if ($this->foto instanceof UploadedFile) {
      $manager = new ImageManager(new Driver());
      $image = $manager->read($this->foto);
      $filename =  time() . '.' . $this->foto->getClientOriginalExtension();
      $destino = public_path("storage/imagenes/adquirentes/");
      $image->scale(width: 400);
      $image->save($destino . $filename);
    }


    $user = User::create([
      'name' => $this->nombre,
      'email' => $this->mail,
      "password" => bcrypt($this->password),
    ]);

    $adq = "";
    if ($user) {

      $adq = Adquirente::create([
        "nombre" => $this->nombre,
        "apellido" => $this->apellido,
        "alias" => $this->alias,
        "telefono" => $this->telefono,
        "CUIT" => $this->CUIT,
        "domicilio" => $this->domicilio,
        "comision" => $this->comision,
        "estado_id" => $this->estado_id,
        "foto" => $filename,
        "condicion_iva_id" => $this->condicion_iva_id,
        "user_id" => $user->id
      ]);


      if ($this->autorizados) {
        return $this->dispatch("autorizado", $adq->id);
      }

      // AGREGAR ROLE ----------------------------------------- ++++++++++++++++++++++++++++++++++++++++++++++++++++


      $this->dispatch('adquirenteCreated');
    }
  }





  public function update()
  {
    if (!$this->adquirente) {
      $this->dispatch('adquirenteNotExits');
    } else {
      $this->validate();

      $filename = '';

      if ($this->foto instanceof UploadedFile) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->foto);
        $filename =  time() . '.' . $this->foto->getClientOriginalExtension();
        $destino = public_path("storage/imagenes/adquirentes/");
        $image->scale(width: 400);
        $image->save($destino . $filename);
      }

      if ($filename) {
        $this->adquirente->foto = $filename;
      }
      if ($this->password) {
        $this->adquirente->user->password = bcrypt($this->password);
      }
      $this->adquirente->user->email = $this->mail;
      $this->adquirente->user->name = $this->nombre;
      $this->adquirente->user->save();

      $this->adquirente->nombre = $this->nombre;
      $this->adquirente->apellido = $this->apellido;
      $this->adquirente->alias = $this->alias;
      $this->adquirente->telefono = $this->telefono;
      $this->adquirente->CUIT = $this->CUIT;
      $this->adquirente->domicilio = $this->domicilio;
      $this->adquirente->comision = $this->comision;
      $this->adquirente->estado_id = $this->estado_id;
      $this->adquirente->condicion_iva_id = $this->condicion_iva_id;

      $this->adquirente->save();


      // VER ESTADO_ID PARA AGREGAR ROLE LUEGO 
      $this->dispatch('adquirenteUpdated');
    }
  }

  public function delete()
  {

    if (!$this->adquirente) {
      $this->dispatch('adquirenteNotExits');
    } else {

      $this->adquirente->autorizados()->delete();
      $this->adquirente->user()->delete();
      $this->adquirente->delete();
      $this->dispatch('adquirenteDeleted');
    }
  }


  public function render()
  {
    return view('livewire.admin.adquirentes.modal');
  }
}
