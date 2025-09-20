<?php

namespace App\Livewire;

use App\Models\Lote;
use App\Models\Moneda;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalPuja extends Component
{

  public $adquirente_id;
  public $lote_id;
  public $lote;
  public $adquirenteEsGanador;
  public $actual;
  public $actualParam;
  public $subastaActiva;
  public $oferta;
  public $signo;
  public $monedas;
  public $base;
  public $loader;


  // public function mostrarError()
  #[On('error-puja')]
  public function mostrarError($loteId, $mensaje)
  {
    $this->loader = false;
    $this->addError('puja.' . $loteId, $mensaje);
    $this->actual = $this->lote->getPujaFinal()->monto;
    $this->actualParam = $this->actual;
  }

  #[On('existo-puja')]
  public function pujaOk($monto)
  {
    $this->loader = false;
    // $this->addError('puja.' . $loteId, $mensaje);
    $this->actual = $monto;
    $this->adquirenteEsGanador = true;
  }



  public function registrarPuja($loteId, $ultimoMontoVisto, $monto)
  {
    $this->loader = true;
    $this->dispatch("registrarPujaModal", loteId: $loteId, ultimoMontoVisto: $ultimoMontoVisto, monto: $monto);
  }



  #[On('timer-expired')]
  public function s2()
  {
    info("seeee2");
    $this->s();
  }

  #[On('echo:my-channel,PujaRealizada')]
  public function s()
  {
    $this->loader = false;
    $this->lote = Lote::with(['pujas', 'ultimoContrato.subasta']) // carga relaciones necesarias
      ->findOrFail($this->lote_id);

    $this->actual = optional($this->lote->getPujaFinal())->monto !== null
      ? (int) $this->lote->getPujaFinal()->monto
      : 0;

    $this->actualParam = $this->actual;

    $this->adquirenteEsGanador = $this->lote?->getPujaFinal()?->adquirente_id === $this->adquirente_id;
  }



  public function re($ra, $wa)
  {
    sleep(2);
  }
  public function mount()
  {

    // dd("ANDUVO OFERTA , VER ERROR EN LOG , CREO QUE REVERB");

    $this->lote = Lote::with(['pujas', 'ultimoContrato.subasta']) // carga relaciones necesarias
      ->findOrFail($this->lote_id);

    if (!$this->lote) {
      // dd("bad");
    }


    // $moneda = Moneda::find($this->lote->moneda)->value("signo");
    $this->signo = Moneda::find($this->lote->moneda)->signo;
    // info(["moneda" => $moneda]);


    $this->actual = optional($this->lote->getPujaFinal())->monto !== null
      ? (int) $this->lote->getPujaFinal()->monto
      : 0;

    $this->actualParam = $this->actual;

    $this->actual = number_format($this->actual, 0, ',', '.');

    $this->adquirenteEsGanador = $this->lote?->getPujaFinal()?->adquirente_id === $this->adquirente_id;

    $this->subastaActiva = \Carbon\Carbon::parse(
      $this->lote->ultimoConLote?->tiempo_post_subasta_fin ?? $this->lote->ultimoContrato?->subasta?->fecha_fin
    )->gte(now());
  }

  public function render()
  {
    return view('livewire.modal-puja');
  }
}
