<?php

namespace App\Livewire\Admin\Auxiliares\Monedas;

use App\Models\Moneda;
use Livewire\Component;

class Modal extends Component
{

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $moneda;
  public $titulo;

  protected function rules()
  {

    if ($this->method == "update") {
      $rules["titulo"] = 'required|unique:monedas,titulo,' . $this->moneda->id;
    } else {
      $rules["titulo"] = 'required|unique:monedas,titulo';
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
      $this->moneda = Moneda::find($this->id);
      $this->id = $this->moneda->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->moneda = Moneda::find($this->id);
      $this->titulo =  $this->moneda->titulo;

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

    Moneda::create([
      "titulo" => $this->titulo,
    ]);

    $this->dispatch('monedaCreated');
  }


  public function update()
  {

    if (!$this->moneda) {
      $this->dispatch('monedaNotExits');
    } else {
      $this->validate();

      $this->moneda->titulo = $this->titulo;

      $this->moneda->save();
      $this->dispatch('monedaUpdated');
    }
  }

  public function delete()
  {
    if (!$this->moneda) {
      $this->dispatch('monedaNotExits');
    } else {
      $this->moneda->delete();
      $this->dispatch('monedaDeleted');
    }
  }

  public function render()
  {
    return view('livewire.admin.auxiliares.monedas.modal');
  }
}
