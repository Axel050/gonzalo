<?php

namespace App\Livewire\Admin\Auxiliares\TipoBien;

use App\Models\Personal;
use App\Models\TiposBien;
use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $tipo;
  public $nombre;
  public $encargados = [];
  public $encargado_id;
  public $suplente_id;
  public $campos;

  protected function rules()
  {
    $rules = [
      'nombre' => 'required|unique:tipos_biens,nombre',
      'encargado_id' => 'required',
    ];

    if ($this->method == "update") {
      $rules["nombre"] = 'required|unique:tipos_biens,nombre,' . $this->tipo->id;
    } else {
      $rules["nombre"] = 'required|unique:tipos_biens,nombre';
    }

    return $rules;
  }

  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "nombre.unique" => "Nombre existente.",
      "encargado_id.required" => "Elija encargado.",
    ];
  }



  public function mount()
  {

    $this->encargados = Personal::orderBy("nombre")->get();

    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->tipo = TiposBien::find($this->id);
      $this->id = $this->tipo->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->tipo = TiposBien::find($this->id);
      $this->nombre =  $this->tipo->nombre;
      $this->encargado_id =  $this->tipo->encargado_id;
      $this->suplente_id =  $this->tipo->suplente_id;

      if ($this->method == "update") {
        $this->title = "Editar";
        $this->bg = "background-color: rgb(234 88 12)";
        $this->btnText = "Guardar";
      } else {
        $this->title = "Ver";
        $this->bg =  "background-color: rgb(31, 83, 44)";
      }
    }
    $this->dispatch('modalOpenedTipoBien', encargadoId: $this->encargado_id, suplenteId: $this->suplente_id);
  }


  #[On('setSuplente')]
  public function setSuplenteId($id)
  {
    $this->suplente_id = $id;
  }

  #[On('setEncargado')]
  public function setEncargadoId($id)
  {
    $this->encargado_id = $id;
  }

  public function save()
  {
    info($this->suplente_id);
    $this->validate();

    $tipo = TiposBien::create([
      "nombre" => $this->nombre,
      "encargado_id" => $this->encargado_id,
      "suplente_id" => $this->suplente_id,
    ]);

    if ($this->campos) {
      return $this->dispatch("campos", $tipo->id);
    }


    $this->dispatch('tipoCreated');
  }


  public function update()
  {

    if (!$this->tipo) {
      $this->dispatch('tipoNotExits');
    } else {
      $this->validate();

      $this->tipo->nombre = $this->nombre;
      $this->tipo->encargado_id = $this->encargado_id;
      $this->tipo->suplente_id = $this->suplente_id;

      $this->tipo->save();
      $this->dispatch('tipoUpdated');
    }
  }

  public function delete()
  {
    if (!$this->tipo) {
      $this->dispatch('tipoNotExits');
    } else {
      $this->tipo->tbcaracteristicas()->delete();
      $this->tipo->delete();
      $this->dispatch('tipoDeleted');
    }
  }

  public function render()
  {
    return view('livewire.admin.auxiliares.tipo-bien.modal');
  }
}
