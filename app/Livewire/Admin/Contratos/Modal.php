<?php

namespace App\Livewire\Admin\Contratos;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Subasta;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Modal extends Component
{

  public $test;

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $contrato;
  public $contrato_id;
  public $nombre;

  public $descripcion;


  public $lotes = true;
  public $comitente_id;

  public $subastas = [];
  public $comitentes = [];

  public $adquirente_id, $subasta_id, $monto, $fecha, $fecha_devolucion, $estado;





  protected function rules()
  {

    $rules = [
      'comitente_id' => 'required',
      'fecha' => 'required|date',
    ];

    return $rules;
  }

  protected function messages()
  {
    return [
      "comitente_id.required" => "Elija comitente.",
      "fecha_firma.required" => "Elija fecha.",
    ];
  }


  public function mount()
  {



    $this->subastas = Subasta::orderBy("id")->get();
    $this->comitentes = Comitente::with("alias")->orderBy("nombre")->get();


    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->contrato = Contrato::find($this->id);
      $this->id = $this->contrato->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->contrato = Contrato::find($this->id);
      $this->comitente_id =  $this->contrato->comitente_id;
      $this->subasta_id =  $this->contrato->subasta_id;
      $this->fecha =  $this->contrato->fecha_firma;
      $this->descripcion =  $this->contrato->descripcion;


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

    $contrato  = Contrato::create([
      "comitente_id" => $this->comitente_id,
      "descripcion" => $this->descripcion,
      "subasta_id" => $this->subasta_id,
      "fecha_firma" => $this->fecha,
    ]);

    if ($this->lotes && $contrato) {
      return $this->dispatch("lotes", $contrato->id);
    }

    $this->dispatch('contratoCreated');
  }


  public function update()
  {

    if (!$this->contrato) {
      $this->dispatch('contratoNotExits');
    } else {
      $this->validate();

      $this->contrato->subasta_id = $this->subasta_id;
      $this->contrato->adquirente_id = $this->adquirente_id;
      $this->contrato->monto = $this->monto;
      $this->contrato->estado = $this->estado;
      $this->contrato->fecha = $this->fecha;
      $this->contrato->fecha_devolucion = $this->fecha_devolucion ? $this->fecha_devolucion :  NULL;

      $this->contrato->save();
      $this->dispatch('contratoUpdated');
    }
  }

  public function delete()
  {
    if (!$this->contrato) {
      $this->dispatch('contratoNotExits');
    } else {
      $this->contrato->delete();
      $this->dispatch('contratoDeleted');
    }
  }


  public function render()
  {
    return view('livewire.admin.contratos.modal');
  }
}
