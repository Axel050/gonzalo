<?php

namespace App\Livewire;

use App\Models\Subasta;
use App\Services\MPService;
use Livewire\Component;


class ModalNoHabilitadoPujar extends Component
{
  public $subasta, $adquirente, $init, $lote;

  public function mp(MPService $mpService)
  {

    $subasta = Subasta::find($this->subasta);
    $preference = $mpService->crearPreferencia("Garantia", 1, $subasta->garantia, $this->adquirente, $this->subasta, $this->lote);

    if ($preference) {
      // $this->init = $preference->init_point;
      return redirect()->away($preference->init_point);
    }
    // info(["PPPP" => $preference]);
  }


  public function render()
  {
    return view('livewire.modal-no-habilitado-pujar');
  }
}
