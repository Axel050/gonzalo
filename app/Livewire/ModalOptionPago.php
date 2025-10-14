<?php

namespace App\Livewire;

use App\Services\MPService;
use Livewire\Component;

class ModalOptionPago extends Component
{

  public $adquirente;
  public $subasta;
  public $orden;

  public $monto;

  public $route;
  public $from;




  public function mount()
  {
    if ($this->from === "orden") {
      $this->monto = $this->orden->total_neto;
    } else {
      $this->monto = $this->subasta->garantia;
    }
  }



  public function mp(MPService $mpService)
  {


    // info(
    //   [
    //     "adquiernte" => $this->adquirente,
    //     "subasta" => $this->subasta,
    //     "orden" => $this->orden,
    //   ]
    // );


    if ($this->from === "orden") {
      # code...
      $route = "/subastas/";

      // Creamos preferencia desde el servicio
      $preference = $mpService->crearPreferenciaOrden(
        $this->adquirente,
        $this->subasta,
        $this->orden,
        $route
      );
    } else {
      $route = "/subastas/" . $this->subasta->id . "/lotes";
      $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente->id, $this->subasta->id, null,  $route);
    }


    info("xxxxxxxxxxxxxxxxxxxxxxx");
    // $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente->id, $this->subasta->id, null,  $route);
    // $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente->id, 66, null,  $route);

    if ($preference) {
      return redirect()->away($preference->init_point);
    }


    // info(
    // return redirect($preference['init_point']); // Redirige al checkout
  }





  public function render()
  {
    return view('livewire.modal-option-pago');
  }
}
