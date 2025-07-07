<?php

namespace App\Livewire\Admin\Depositos;

use App\Models\Adquirente;
use App\Models\Deposito;
use App\Models\Subasta;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{

  public $mounted;
  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $deposito;
  public $nombre;

  public $subastas = [];
  public $adquirentes = [];

  public $adquirente_id, $subasta_id, $monto, $fecha, $fecha_devolucion, $estado;



  public function updatedSubastaId()
  {

    $s = Subasta::find($this->subasta_id);

    if ($s) {
      $this->monto = $s->garantia;
    }
    $this->dispatch('modalOpenedGarantias', adquirenteId: $this->adquirente_id); // Envía el ID
  }



  protected function rules()
  {

    $rules = [
      'subasta_id' => [
        'required',
        Rule::unique('depositos')->where(function ($query) {
          return $query->where('adquirente_id', $this->adquirente_id);
        })
      ],
      'adquirente_id' => 'required',
      'monto' => 'required|numeric',
      'estado' => 'required',
      'fecha' => 'required|date',

    ];

    if ($this->estado == "devuelto") {
      $rules["fecha_devolucion"] = 'required|date';
    }

    if ($this->method == "update") {
      $rules['subasta_id'] = [
        'required',
        Rule::unique('depositos')->where(function ($query) {
          return $query->where('adquirente_id', $this->adquirente_id);
        })->ignore($this->deposito->id)
      ];
    }

    return $rules;
  }


  protected function messages()
  {
    return [
      "subasta_id.required" => "Elija subasta.",
      "subasta_id.unique" => "Depostio existente .",
      "adquirente_id.required" => "Elija adquirente.",
      "monto.required" => "Ingrese monto.",
      "fecha.required" => "Elija fecha.",
      "estado.required" => "Elija estado.",
      "fecha_devolucion.required" => "Elija fecha.",
    ];
  }


  public function mount()
  {
    $this->subastas = Subasta::orderBy("id")->get();
    $this->adquirentes = Adquirente::orderBy("nombre")->get();

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


    $this->dispatch('modalOpenedGarantias', adquirenteId: $this->adquirente_id); // Envía el ID    
  }


  #[On('setAdquirente')]
  public function setAdquirenteId($id)
  {
    $this->adquirente_id = $id;
  }

  public function test()
  {
    $this->monto = 11;
    // info("88888888888888888888888888888");
  }

  public function updated($propertyName, $value)
  {
    info("wUPPPPPPPPPPPP");
  }


  public function save()
  {

    $this->validate();

    Deposito::create([
      "subasta_id" => $this->subasta_id,
      "adquirente_id" => $this->adquirente_id,
      "monto" => $this->monto,
      "fecha" => $this->fecha,
      "fecha_devolucion" => $this->fecha_devolucion,
      "estado" => $this->estado,
    ]);

    $this->dispatch('depositoCreated');
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




    return view('livewire.admin.depositos.modal');
  }
}
