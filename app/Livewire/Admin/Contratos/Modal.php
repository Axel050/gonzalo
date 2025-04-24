<?php

namespace App\Livewire\Admin\Contratos;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Deposito;
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

  public $deposito;
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
    $this->comitentes = Comitente::select('id', 'nombre', 'apellido')->orderBy("nombre")->get();

    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->deposito = Deposito::find($this->id);
      $this->id = $this->deposito->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->deposito = Deposito::find($this->id);
      $this->adquirente_id =  $this->deposito->adquirente_id;
      $this->subasta_id =  $this->deposito->subasta_id;
      $this->fecha_devolucion =  $this->deposito->fecha_devolucion;
      $this->fecha =  $this->deposito->fecha;
      $this->monto =  $this->deposito->monto;
      $this->estado =  $this->deposito->estado;

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
      "fecha_firma" => $this->fecha,
    ]);

    if ($this->lotes && $contrato) {
      return $this->dispatch("lotes", $contrato->id);
    }

    $this->dispatch('contratoCreated');
  }


  public function update()
  {

    if (!$this->deposito) {
      $this->dispatch('depositoNotExits');
    } else {
      $this->validate();

      $this->deposito->subasta_id = $this->subasta_id;
      $this->deposito->adquirente_id = $this->adquirente_id;
      $this->deposito->monto = $this->monto;
      $this->deposito->estado = $this->estado;
      $this->deposito->fecha = $this->fecha;
      $this->deposito->fecha_devolucion = $this->fecha_devolucion ? $this->fecha_devolucion :  NULL;

      $this->deposito->save();
      $this->dispatch('depositoUpdated');
    }
  }

  public function delete()
  {
    if (!$this->deposito) {
      $this->dispatch('depositoNotExits');
    } else {
      $this->deposito->delete();
      $this->dispatch('depositoDeleted');
    }
  }


  public function render()
  {
    return view('livewire.admin.contratos.modal');
  }
}
