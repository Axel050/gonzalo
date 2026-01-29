<?php

namespace App\Livewire\Admin\Adquirentes;

use App\Enums\CarritoLoteEstados;
use App\Livewire\Traits\UploadSecurity;
use App\Models\Adquirente;
use App\Models\AdquirentesAlias;
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
  use UploadSecurity;

  public $owner = false;
  public $email_alias;
  public $telefono_alias;
  public $existe = false;
  public $aliases;

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $adquirente;
  public $alias_id;

  public $nombre, $apellido, $alias, $CUIT, $domicilio, $telefono, $mail, $banco, $numero_cuenta, $CBU, $alias_bancario, $foto, $estado_id, $domicilio_envio;
  public $password;
  public  $password_confirmation;
  public $comision = 20;
  public $condicion_iva_id = 4;
  public $estados = [];
  public $condiciones = [];
  public $ver = false;
  public $typePass = "password";

  public $autorizados;


  public function updatedFoto()
  {

    $this->resetErrorBag('foto');
    try {

      if (
        $this->isDangerousExtension($this->foto) ||
        ! in_array($this->foto->getMimeType(), [
          'image/jpeg',
          'image/png',
          'image/webp',
        ], true)
      ) {
        $this->addUploadSecurityError('foto');
        $this->reset('foto');
        return;
      }


      $this->validate(
        [
          'foto' => 'file|max:20000|mimetypes:image/jpeg,image/png',

        ],
        [
          'foto.max' => "Menor a 20mb",
          'foto.mimetypes' => 'archivo invalido'
        ]


      );
    } catch (\Illuminate\Validation\ValidationException $e) {
      unlink($this->foto->getRealPath());
      $this->addError('foto', $e->validator->errors()->first('foto'));
      $this->reset('foto');
    }
  }



  private function isDangerousExtensioeeen(UploadedFile $file): bool
  {
    $ext = strtolower($file->getClientOriginalExtension());

    return in_array($ext, [
      'php',
      'php3',
      'php4',
      'php5',
      'phtml',
      'phar',
      'exe',
      'sh',
      'bat',
      'cmd',
      'js',
      'html',
      'htm'
    ]);
  }




  public function updatedAliasId($value)
  {
    $ad = AdquirentesAlias::find($value);
    if ($ad) {
      $this->telefono_alias = $ad->adquirente?->telefono;
      $this->email_alias = $ad->adquirente?->user?->email;
    }
  }

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
      if (!$this->existe && $this->owner) {
        $rules["alias_id"] = 'unique:adquirentes_aliases,nombre,' . $this->adquirente->alias_id;
      }

      $rules['mail'] = 'required|email|unique:users,email,' . $this->adquirente->user->id;

      if ($this->password || $this->password_confirmation) {
        $rules['password'] = 'required|string|confirmed|min:8';
      }
    } else {
      $rules["CUIT"] = 'required|unique:adquirentes,CUIT';
      $rules['password'] = 'required|string|confirmed|min:8';
      $rules['mail'] = 'required|email|unique:users,email';
    }

    if (!$this->existe && !$this->owner) {
      $rules["alias_id"] = 'unique:adquirentes_aliases,nombre,';
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
      "alias_id.unique" => "Alias existente.",
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

    $this->aliases = AdquirentesAlias::all();

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
      $this->mail =  $this->adquirente->user->email;
      $this->telefono =  $this->adquirente->telefono;
      $this->CUIT =  $this->adquirente->CUIT;
      $this->domicilio =  $this->adquirente->domicilio;
      $this->domicilio_envio =  $this->adquirente->domicilio_envio;
      $this->condicion_iva_id =  $this->adquirente->condicion_iva_id;
      $this->estado_id =  $this->adquirente->estado_id;
      $this->foto =  $this->adquirente->foto;

      if ($this->adquirente->comision !== null) {
        $comision = floatval($this->adquirente->comision);
        $comision = ($comision == floor($comision)) ? (int)$comision : $comision;
        $this->comision =  $comision;
      }

      if ($this->adquirente->id == $this->adquirente->alias?->adquirente_id) {
        $this->owner = true;
      }

      if ($this->adquirente->alias_id && !$this->owner) {
        $this->existe = true;
        $this->alias_id =  $this->adquirente->alias_id;
        $this->email_alias =  $this->adquirente->alias?->adquirente?->user?->email;
        $this->telefono_alias =  $this->adquirente->alias?->adquirente?->telefono;
      }

      if ($this->adquirente->alias_id && $this->owner) {
        $this->alias_id = $this->adquirente->alias->nombre;
      }

      $this->CBU =  $this->adquirente->CBU;
      $this->numero_cuenta =  $this->adquirente->numero_cuenta;
      $this->banco =  $this->adquirente->banco;
      $this->alias_bancario =  $this->adquirente->alias_bancario;


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
      // $filename =  time() . '.' . $this->foto->getClientOriginalExtension();
      $filename = time() . '.png';
      $destino = public_path("storage/imagenes/adquirentes/");
      $image->scale(width: 400);
      $image->save($destino . $filename);
    }


    $user = User::create([
      'name' => $this->nombre,
      'email' => $this->mail,
      "password" => bcrypt($this->password),
    ]);

    // $user->assign
    $user->assignRole("adquirente");

    $adq = "";
    if ($user) {

      $adq = Adquirente::create([
        "nombre" => $this->nombre,
        "apellido" => $this->apellido,
        "telefono" => $this->telefono,
        "CUIT" => $this->CUIT,
        "domicilio" => $this->domicilio,
        "domicilio_envio" => $this->domicilio_envio,
        "comision" => $this->comision,
        "estado_id" => $this->estado_id,
        "foto" => $filename,
        "condicion_iva_id" => $this->condicion_iva_id,
        "user_id" => $user->id,
        "CBU" => $this->CBU,
        "numero_cuenta" => $this->numero_cuenta,
        "alias_bancario" => $this->alias_bancario,
        "banco" => $this->banco,
      ]);

      if ($this->existe && isset($this->alias_id)) {
        $adq->alias_id =  $this->alias_id;
        $adq->save();
      }

      if (!$this->existe && isset($this->alias_id)) {


        $adAl = AdquirentesAlias::create([
          "nombre" => $this->alias_id,
          "adquirente_id" => $adq->id
        ]);

        if ($adAl) {
          $adq->alias_id =  $adAl->id;
          $adq->save();
        }
      }




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

      if ($this->owner && $this->adquirente->alias->adquirentes() > 1) {
        if ($this->existe) {
          if ($this->adquirente->alias_id   != $this->alias_id) {
            return  $this->addError('alias_id', 'Su alias esta vinculado con otro adquirentes.');
          }
        }

        if (!$this->alias_id) {
          return  $this->addError('alias_id', 'Ingrese alias.');
        }
      }

      // dd("ae5daed");
      $filename = '';

      if ($this->foto instanceof UploadedFile) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->foto);
        // $filename =  time() . '.' . $this->foto->getClientOriginalExtension();
        $filename = time() . '.png';

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
      $this->adquirente->telefono = $this->telefono;
      $this->adquirente->CUIT = $this->CUIT;
      $this->adquirente->domicilio = $this->domicilio;
      $this->adquirente->domicilio_envio = $this->domicilio_envio;
      $this->adquirente->comision = $this->comision;
      $this->adquirente->estado_id = $this->estado_id;
      $this->adquirente->condicion_iva_id = $this->condicion_iva_id;

      $this->adquirente->CBU = $this->CBU;
      $this->adquirente->banco = $this->banco;
      $this->adquirente->alias_bancario = $this->alias_bancario;
      $this->adquirente->numero_cuenta = $this->numero_cuenta;


      if (!$this->existe && isset($this->alias_id)) {

        if (!$this->owner) {
          $adAl = AdquirentesAlias::create([
            "nombre" => $this->alias_id,
            "adquirente_id" => $this->adquirente->id,
          ]);
          $this->adquirente->alias_id = $adAl->id;
        } elseif ($this->owner) {
          $this->adquirente->alias->nombre = $this->alias_id;
          $this->adquirente->alias->save();
        }
      } else {
        $this->adquirente->alias_id = $this->alias_id;
      }


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



      // Dentro del método delete()

      // check que pasa con los soft delettes , si los boramos al borrar al padre o  que 
      if ($this->adquirente->carrito?->carritoLotes()->activos()->exists()) {
        $this->addError('tieneDatos', 'Adquirente con lotes  estado:activo en carrito.');
        return;
      }

      if ($this->adquirente->carrito?->carritoLotes()->adjudicados()->exists()) {
        $this->addError('tieneDatos', 'Adquirente  con lotes estado:adjudicados en carrito.');
        return;
      }

      if ($this->adquirente->carrito?->carritoLotes()->enOrden()->exists()) {
        $this->addError('tieneDatos', 'Adquirente con lotes  estado:en_orden en carrito.');
        return;
      }



      if ($this->adquirente->garantias()->exists()) {
        $this->addError('tieneDatos', 'Adquirente con  garantías.');
        return;
      }

      if ($this->adquirente->ordenes()->exists()) {
        $this->addError('tieneDatos', 'Adquirente con  ordenes asociadas.');
        return;
      }

      if ($this->adquirente->autorizados()->exists()) {
        $this->addError('tieneDatos', 'Adquirente con  autorizados asociados.');
        return;
      }





      if (!$this->adquirente?->carrito()->exists()) {
        $this->adquirente->user()->delete();
      }


      $this->adquirente->delete();
      $this->dispatch('adquirenteDeleted');
    }
  }


  public function render()
  {
    return view('livewire.admin.adquirentes.modal');
  }
}
