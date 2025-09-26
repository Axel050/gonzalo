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

    $route = "/lotes/" . $this->lote;
    // info(["ROUTE" => $route]);
    $subasta = Subasta::find($this->subasta);
    // info([
    //   "ANTES PREFERENCE MODAL " => "aaa",
    //   "subasta garantia" => $subasta->garantia,
    //   "adquirente" => $this->adquirente,
    //   "subasta" => $this->subasta,
    //   "lote" => $this->lote,
    //   "rpute" => $route,
    // ]);

    $preference = $mpService->crearPreferencia("Garantia", 1, $subasta->garantia, $this->adquirente, $this->subasta, $this->lote,  $route);

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
