<?php

namespace App\Livewire;

use App\Models\Lote;
use App\Models\Puja;
use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Component;

class DetalleLote extends Component
{
  public $id;
  public $subasta;
  public $lote;
  public $own = false;
  public $adquirente;
  public $base;
  public $ultimaOferta;
  public $pujado;

  public $second = "anda";


  // $this->lote->refresh()= Lote::find($this->id);
  // NOSE PRI QUE NO ACTUALIZA EL OWN 
  #[On('echo:my-channel,PujaRealizada')]
  public function test($event)
  {

    if (isset($event['loteId']) && $this->lote?->id !== $event['loteId']) {
      return;
    }

    if ($this->lote?->getPujaFinal()?->adquirente_id == $this->adquirente?->id) {
      $this->own = true;
    } else {
      $this->own = false;
    }
    $this->ultimaOferta = $this->lote?->getPujaFinal()?->monto;
    $this->pujado = false;
    // $this->lote->refresh();
  }


  // #[On('echo:my-channel,PujaRealizada')]

  public function mount()
  {
    $this->adquirente = auth()->user()?->adquirente;
    $this->subasta = Subasta::find(9);
    $this->lote = Lote::find($this->id);
    $this->base = $this->lote?->precio_base;
    $this->ultimaOferta = $this->lote?->getPujaFinal()?->monto;
    info(["mouit Detalle lote" => $this->lote?->getPujaFinal()?->monto]);
    // info([" puja  " => $this->lote?->getPujaFinal()?->monto]);
    // info([" puja  " => $this->lote?->getPujaFinal()?->monto]);
    // info([" puja Adquire  " => $this->lote?->getPujaFinal()?->adquirente_id]);
    if ($this->lote?->getPujaFinal()?->adquirente_id == $this->adquirente?->id) {
      $this->own = true;
    }
    // info(["puha final"  => $this->lote?->getPujaFinal()]);
    // info(["puha adquirente "  => $this->adquirente?->id]);
    // info(["OWN"   => $this->ownPuja]);
  }

  public function registrarPuja($loteId, $monto)
  {
    if ($this->lote?->getPujaFinal()?->adquirente_id == $this->adquirente?->id) {
      $this->addError('puja', 'Tu oferta es la ultima ');
      return;
    }

    $lote = Lote::find($this->id);
    info("registrar puja ");
    // $lote = $this->subasta->lotesActivos()->where('lotes.id', $loteI d)->first();
    // $lote = $this->subasta->lotesActivos()->where('lotes.id', $this->id)->first();

    $lote = Lote::find($this->id);
    $contratoLote = $lote->contratoLotes()
      ->whereHas('contrato', fn($query) => $query->where('subasta_id', $this->subasta->id))
      ->first();

    info(["COntrato lotes " => $contratoLote->toArray()]);

    // info("registrar IFF ");
    if (!$this->subasta->isActiva() || !$contratoLote || !$contratoLote->isActivo()) {
      $this->addError('puja', 'Subasta o lote inactivo');
      return;
    }
    // 'adquirente_id' => auth()->id(),
    // info("Antes create");



    $ultimoMonto = Puja::where('lote_id', $this->id)
      ->where('subasta_id', 9)
      ->orderByDesc('id') // o 'created_at' si prefieres
      ->value('monto');

    $montoFinal = $ultimoMonto + $monto;
    // info(["monto" => $monto]);
    info(["montoF" => $montoFinal]);

    Puja::create([
      'adquirente_id' => $this->adquirente?->id,
      'lote_id' => $lote->id,
      'subasta_id' => $this->subasta->id,
      // 'monto' => $monto,
      'monto' => $montoFinal,
    ]);


    // info(["Deposi tiemo " => $this->subasta->tiempo_post_subasta]);
    if (now()->gt($this->subasta->fecha_fin)) {
      $contratoLote->update(['tiempo_post_subasta_fin' => now()->addMinutes($this->subasta->tiempo_post_subasta)]);
    }


    // }
    // info("pujajjjjjjaaaa");
    // event(new \App\Events\PujaRealizada(null, $this->subasta, $lote));
    event(new \App\Events\PujaRealizada($this->lote->id, $montoFinal));
    $this->pujado = true;
    $this->ultimaOferta = $montoFinal;
    //   $this->loadLotes(); // Recargar lotes después de la puja



  }


  public function render()
  {
    return view('livewire.detalle-lote');
  }
}
