<?php

namespace App\Livewire\Admin\Auxiliares\TipoBien;

use Livewire\Component;
use App\Models\Caracteristica;
use App\Models\TiposBien;
use Livewire\Attributes\On;

class ModalCampos extends Component
{

  public $id;

  public $tipo;
  public $nombre;

  public $tempCampos = [];
  public $caracteristicas = [];
  public $camp;
  public $requerido = false;

  public function mount()
  {

    $this->tipo = TiposBien::find($this->id);
    $this->caracteristicas = Caracteristica::orderBy("nombre")->get();

    $this->tempCampos = $this->tipo->tbcaracteristicas->toArray();
    $this->dispatch('modalOpenedTipoBienCampo');
  }

  #[On('setCampo')]
  public function setCampo($id)
  {
    $this->camp = $id;
  }


  protected function rules()
  {
    $rules = [
      'camp' => 'required',
    ];
    return $rules;
  }


  protected function messages()
  {
    return [
      "camp.required" => "Elija campo.",
    ];
  }



  public function add()
  {
    $this->validate();
    [$campo, $tipo, $id] = explode("-/", $this->camp);

    $campoExistsInTemp = array_search($campo, array_column($this->tempCampos, 'nombre')) !== false;
    if ($campoExistsInTemp) {
      $this->addError('camp', 'El campo ya está en la lista.');
      return;
    }

    $this->tempCampos[] = [
      'nombre' => $campo,
      'tipo' => $tipo,
      "id" => $id,
      "pivot" => [
        "requerido" => $this->requerido
      ]
    ];

    $this->camp = "";
    $this->dispatch('reset-tom-select-campo');
    // $this->reset(['camp']);
  }



  public function quitar($index)
  {
    if (isset($this->tempCampos[$index])) {
      unset($this->tempCampos[$index]);
      $this->tempCampos = array_values($this->tempCampos);
    }
  }




  public function save()
  {
    $syncData = [];

    foreach ($this->tempCampos as $campo) {
      $syncData[$campo['id']] = [
        'requerido' => $campo["pivot"]["requerido"]
      ];
    }

    $this->tipo->tbcaracteristicas()->sync($syncData);
    $this->dispatch('campoCreated');
  }



  public function render()
  {
    return view('livewire.admin.auxiliares.tipo-bien.modal-campos');
  }
}
