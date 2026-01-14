<?php

namespace App\Livewire;

use App\Models\Subasta;
use App\Services\MPService;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ModalOptionPago extends Component
{

  public $adquirente;


  #[Locked]
  public Subasta $subasta;

  #[Locked]
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
      // $subasta = Subasta::findOrFail($this->subasta);

      $this->monto = $this->subasta?->garantia;
    }
  }



  // public function mp(MPService $mpService)
  // {




  //   if ($this->from === "orden") {

  //     $route = "/subastas/";

  //     $preference = $mpService->crearPreferenciaOrden(
  //       $this->adquirente,
  //       $this->subasta,
  //       $this->orden,
  //       $route,
  //       $this->conEnvio,
  //       $this->montoEnvio
  //     );
  //   } else {
  //     $route = "/subastas/" . $this->subasta->id . "/lotes";
  //   }



  //   if ($preference) {
  //     return redirect()->away($preference->init_point);
  //   }

  // }





  public function render()
  {
    return view('livewire.modal-option-pago');
  }
}
