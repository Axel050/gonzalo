<?php

namespace App\Livewire;

use App\Models\Subasta;
use App\Services\MPService;
use Livewire\Component;


class ModalNoHabilitadoPujar extends Component
{
  public $subasta, $adquirente, $init, $lote, $monto, $modalPago;



  public function mount()
  {

    $this->subasta = Subasta::find($this->subasta);
  }


  public function cbu()
  {
    $this->monto = $this->subasta?->garantia ?? 0;
    $this->modalPago = true;
  }


  // public function mp(MPService $mpService)
  // {

  //   $route = "/lotes/" . $this->lote;



  //   $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente, $this->subasta->id, $this->lote,  $route);

  //   if ($preference) {

  //     return redirect()->away($preference->init_point);
  //   }

  // }


  public function render()
  {
    return view('livewire.modal-no-habilitado-pujar');
  }
}
