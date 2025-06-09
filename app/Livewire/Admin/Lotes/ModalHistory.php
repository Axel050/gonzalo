<?php

namespace App\Livewire\Admin\Lotes;

use App\Enums\LotesEstados;
use App\Models\Lote;
use App\Models\Moneda;
use Livewire\Component;


class ModalHistory extends Component
{




  public $modal_foto = false;
  public $search;

  public string $si;

  public $te = 1;

  public $id;
  public $foto1;

  public $moneda_id = 1; //peso
  public $contrato;


  public $lote_id = false;
  public $titulo, $descripcion, $precio_base;
  public $autorizados = [];

  public $tempLotes = [];
  public $method, $index;

  public $lote;
  public $contratosLotes;
  public $monedas;
  public $valuacion;
  public $estado;
  public $estados;







  public function close()
  {
    if ($this->index) {
      info("index");
      $this->dispatch("closeModalToIndex");
    } else {
      info("Noindex");
      $this->dispatch("closeModalToView");
    }
  }

  public function mount()
  {
    $this->estados = array_map(function ($estado) {
      return [
        'value' => $estado,
        'label' => LotesEstados::getLabel($estado),
      ];
    }, LotesEstados::all());

    $this->lote = Lote::find($this->id);
    $this->monedas = Moneda::all()->keyBy('id');
    // $this->contratosLotes = $this->lote->contratosLotes;
    $this->contratosLotes =   $this->lote->contratosLotes()->orderBy('contrato_id', 'desc')->get();

    $this->titulo = $this->lote->titulo;
    $this->descripcion = $this->lote->descripcion;
    $this->valuacion = (int)$this->lote->valuacion;
    $this->estado = $this->lote->estado;
    // $this->tempLotes = $this->contrato->lotes->toArray();
    // $this->contratosLotes = 
  }



  public function render()
  {
    return view('livewire.admin.lotes.modal-history');
  }
}
