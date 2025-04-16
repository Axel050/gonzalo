<?php

namespace App\Livewire\Admin\Personal\Roles;

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

  public $name;
  public $description;
  public $is_active = true;

  public $rol;


  protected function rules()
  {
    $rules = [
      'name' => 'required|unique:roles,name',
    ];

    if ($this->method == "update") {
      $rules["name"] = 'required|unique:roles,name,' . $this->rol->id;
    }


    return $rules;
  }

  protected function messages()
  {
    return [
      "name.required" => "Ingrese nombre.",
      "name.unique" => "Nombre existente.",
    ];
  }


  public function mount()
  {

    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->rol = Role::find($this->id);
      $this->name = $this->rol->name;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->rol = Role::find($this->id);
      $this->name =  $this->rol->name;
      $this->description =  $this->rol->description;
      $this->is_active =  $this->rol->is_active;

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

    Role::create([
      "name" => $this->name,
      "description" => $this->description,
      "is_active" => $this->is_active,
    ]);

    $this->dispatch('rolCreated');
  }


  public function update()
  {

    if (!$this->rol) {
      $this->dispatch('rolNotExits');
    } else {
      $this->validate();

      $this->rol->name = $this->name;
      $this->rol->description = $this->description;
      $this->rol->is_active = $this->is_active;


      $this->rol->save();

      $this->dispatch('rolUpdated');
    }
  }

  public function delete()
  {
    if (!$this->rol) {
      $this->dispatch('rolNotExits');
    } else {
      // $this->rol->user->delete();
      $this->rol->delete();
      $this->dispatch('rolDeleted');
    }
  }

  public function render()
  {
    return view('livewire.admin.personal.roles.modal');
  }
}
