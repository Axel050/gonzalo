<?php

namespace App\Livewire\Admin\Personal\Usuarios;

use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Modal extends Component
{

  use WithFileUploads;

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $foto;
  public $nombre;
  public $apellido;
  public $email;
  public $CUIT;
  public $alias;
  public $telefono;
  public $domicilio;
  public $role_id;
  public $roles;
  public $password, $password_confirmation;

  public $personal;


  protected function rules()
  {
    $rules = [
      'nombre' => 'required',
      'apellido' => 'required',
      // 'domicilio' => 'required',
      'role_id' => 'required',
      'email' => 'required|unique:users,email',
      'alias' => 'unique:personals,alias',
      'telefono' => 'required|unique:personals,telefono',
      // 'CUIT' => 'required|unique:personals,CUIT',
      // 'password' => 'required|unique:personals,CUIT',
    ];

    if ($this->method == "update") {
      $rules["email"] = 'required|unique:users,email,' . $this->personal->user?->id;
      $rules["alias"] = 'unique:personals,alias,' . $this->personal->id;
      $rules["telefono"] = 'required|unique:personals,telefono,' . $this->personal->id;
      if ($this->CUIT) {
        $rules["CUIT"] = 'unique:personals,CUIT,' . $this->personal->id;
      }

      if ($this->password || $this->password_confirmation) {
        $rules['password'] = 'required|string|confirmed|min:8';
      }
    } else {
      $rules['password'] = 'required|string|confirmed|min:8';
    }


    return $rules;
  }

  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "apellido.required" => "Ingrese apellido.",
      "domicilio.required" => "Ingrese domicilio.",
      "email.required" => "Ingrese email.",
      "email.unique" => "Email existente.",
      "alias.required" => "Ingrese alias.",
      "alias.unique" => "Alias existente.",
      "telefono.required" => "Ingrese telefono.",
      "telefono.unique" => "Telefono existente.",
      "CUIT.required" => "Ingrese CUIT.",
      "CUIT.unique" => "CUIT existente.",
      "role_id.required" => "Elija rol.",
      "role_id.required" => "Elija rol.",
      "password.confirmed" => "Confirme contraseña.",
      "password.required" => "Ingrese contraseña.",
      "password.min" => "Minimo 8 caracteres.",

    ];
  }


  public function mount()
  {

    $this->roles = Role::orderBy("name")->get();


    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->personal = Personal::find($this->id);
      $this->nombre = $this->personal->nombre;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->personal = Personal::find($this->id);
      $this->nombre =  $this->personal->nombre;
      $this->apellido =  $this->personal->apellido;
      $this->email =  $this->personal->user?->email;
      $this->CUIT =  $this->personal->CUIT;
      $this->telefono =  $this->personal->telefono;
      $this->foto =  $this->personal->foto;
      $this->alias =  $this->personal->alias;
      $this->domicilio =  $this->personal->domicilio;
      $this->role_id =  $this->personal->role_id;


      if ($this->method == "update") {
        $this->title = "Editar";
        $this->bg = "background-color: rgb(234 88 12)";
        $this->btnText = "Guardar";
      } else {
        $this->title = "Ver";
        $this->bg =  "background-color: rgb(31, 83, 44)";
      }
    }
  }


  public function save()
  {

    $this->validate();


    $filename = '';

    if ($this->foto instanceof UploadedFile) {
      $manager = new ImageManager(new Driver());
      $image = $manager->read($this->foto);
      $filename =  time() . '.' . $this->foto->getClientOriginalExtension();
      $destino = public_path("storage/imagenes/personal/");
      $image->scale(width: 400);
      $image->save($destino . $filename);
    }

    $p = User::create([
      "name" => $this->nombre,
      "email" => $this->email,
      "password" => bcrypt($this->password),
    ]);

    if ($p) {

      Personal::create([
        "nombre" => $this->nombre,
        "apellido" => $this->apellido,
        "alias" => $this->alias,
        "telefono" => $this->telefono,
        "CUIT" => $this->CUIT,
        "domicilio" => $this->domicilio,
        "user_id" => $p->id,
        "role_id" => $this->role_id,
        "foto" => $filename,
      ]);


      $rol = Role::find($this->role_id);
      if ($rol) {
        $p->assignRole($rol->name);
      }
      $this->dispatch('personalCreated');
    }
  }


  public function update()
  {

    if (!$this->personal) {
      $this->dispatch('personalNotExits');
    } else {
      $this->validate();

      if ($this->password) {
        $this->personal->user->password = bcrypt($this->password);
      }

      $this->personal->user->name = $this->nombre;
      $this->personal->user->email = $this->email;

      $filename = "";
      if ($this->foto instanceof UploadedFile) {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->foto);
        $filename =  time() . '.' . $this->foto->getClientOriginalExtension();
        $destino = public_path("storage/imagenes/personal/");
        $image->scale(width: 400);
        $image->save($destino . $filename);
      }

      if ($filename) {
        $this->personal->foto = $filename;
      }

      $this->personal->nombre = $this->nombre;
      $this->personal->apellido = $this->apellido;
      $this->personal->telefono = $this->telefono;
      $this->personal->alias = $this->alias;
      $this->personal->domicilio = $this->domicilio;
      $this->personal->CUIT = $this->CUIT;
      $this->personal->role_id = $this->role_id;

      $rol = Role::find($this->role_id);
      if ($rol) {
        $this->personal->user->syncRoles($rol->name);
      }

      $this->personal->save();
      $this->personal->user->save();
      $this->dispatch('personalUpdated');
    }
  }

  public function delete()
  {
    if (!$this->personal) {
      $this->dispatch('personalNotExits');
    } else {


      if (
        $this->personal->tiposBienEncargado()->exists()
      ) {
        $this->addError(
          'delete',
          'Personal  asignado como ENCARGADO en uno o más tipos de bien.'
        );
        return;
      }

      if (
        $this->personal->tiposBienSuplente()->exists()
      ) {
        $this->addError(
          'delete',
          'Personal  asignado como SUPLENTE en uno o más tipos de bien.'
        );
        return;
      }

      $this->personal->user->delete();
      $this->personal->delete();
      $this->dispatch('personalDeleted');
    }
  }

  public function render()
  {
    return view('livewire.admin.personal.usuarios.modal');
  }
}
