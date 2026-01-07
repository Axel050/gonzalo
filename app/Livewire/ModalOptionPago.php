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

  public $conEnvio;
  public $montoEnvio;

  public $route;
  public $from;




  public function mount()
  {
    if ($this->from === "orden") {

      $this->monto = $this->orden->total_neto;
      if ($this->conEnvio) {
        $this->montoEnvio = $this->orden->subasta?->envio;
        $this->monto += $this->montoEnvio;
      }
    } else {
      $this->monto = $this->subasta->garantia;
    }
  }



  public function mp(MPService $mpService)
  {




    if ($this->from === "orden") {

      $route = "/subastas/";

      $preference = $mpService->crearPreferenciaOrden(
        $this->adquirente,
        $this->subasta,
        $this->orden,
        $route,
        $this->conEnvio,
        $this->montoEnvio
      );
    } else {
      $route = "/subastas/" . $this->subasta->id . "/lotes";
      // $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente->id, $this->subasta->id, null,  $route);
    }



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
