<?php

namespace App\Livewire\Admin\Subastas;


use App\Models\Contrato;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalPujas extends Component

{


  public $modal_foto = false;

  public $lotes = [];
  public $monedas = [];


  public $id;
  public $foto1;

  public $moneda_id = 1; //peso

  public $lote_id = false;
  public $lote_id_modal = false;
  public $titulo, $descripcion, $precio_base;

  public $method;
  public $valuacion;
  public $subasta;
  public $pujas = [];


  public function closeModal()
  {
    // Dispara el evento para cerrar el modal en Alpine.js
    $this->dispatch('close-modal');
    // Limpia la propiedad después de la animación
    $this->modal_foto = null;
  }


  #[On(['loteUpdated', 'loteContrato'])]
  public function mount()
  {

    // dd("ada");
    // $this->monedas = Moneda::all();
    $this->monedas = Moneda::all()->keyBy('id');

    // info(["oprevio mont contrato " => $this->id]);
    $this->subasta = Subasta::find($this->id);

    $this->pujas = $this->subasta->pujas;

    $this->lotes = Lote::whereHas('pujas', function ($q) {
      $q->where('subasta_id', $this->subasta->id);
    })
      ->with([
        'ultimaPuja.adquirente'
      ])
      ->withMax('pujas', 'id')
      ->orderByDesc('pujas_max_id')
      ->get();




    $this->method = "";
  }




  public function render()
  {
    return view('livewire.admin.subastas.modal-pujas');
  }
}
