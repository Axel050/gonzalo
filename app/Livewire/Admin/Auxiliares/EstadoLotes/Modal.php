<?php

namespace App\Livewire\Admin\Auxiliares\EstadoLotes;

use App\Models\EstadosLote;
use Livewire\Component;

class Modal extends Component
{

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;
  public $estado;
  public $titulo;

  protected function rules()
  {

    if ($this->method == "update") {
      $rules["titulo"] = 'required|unique:estados_lotes,titulo,' . $this->estado->id;
    } else {
      $rules["titulo"] = 'required|unique:estados_lotes,titulo';
    }

    return $rules;
  }

  protected function messages()
  {
    return [
      "titulo.required" => "Ingrese nombre.",
      "titulo.unique" => "Nombre existente.",
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
      $this->estado = EstadosLote::find($this->id);
      $this->id = $this->estado->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->estado = EstadosLote::find($this->id);
      $this->titulo =  $this->estado->titulo;

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

    EstadosLote::create([
      "titulo" => $this->titulo,
    ]);

    $this->dispatch('estadoCreated');
  }


  public function update()
  {

    if (!$this->estado) {
      $this->dispatch('estadoNotExits');
    } else {
      $this->validate();

      $this->estado->titulo = $this->titulo;

      $this->estado->save();
      $this->dispatch('estadoUpdated');
    }
  }

  public function delete()
  {
    if (!$this->estado) {
      $this->dispatch('estadoNotExits');
    } else {
      $this->estado->delete();
      $this->dispatch('estadoDeleted');
    }
  }

  public function render()
  {
    return view('livewire.admin.auxiliares.estado-lotes.modal');
  }
}
