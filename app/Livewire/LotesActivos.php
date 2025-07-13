<?php

namespace App\Livewire;

use App\Models\Puja;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Component;

class LotesActivos extends Component
{
  public Subasta $subasta;
  public $lotes = [];
  public $error = null;
  // public $test = "11";
  public $subastaEstado = "11";

  // #[On('echo:subasta.{subasta.id},SubastaEstadoActualizado')]
  // #[On('echo:my-channel.{subasta.id},SubastaEstadoActualizado')]

  #[On('echo:my-channel,SubastaEstadoActualizado')]
  public function actualizarEstado($event)
  {
    // Si cambio manual en la BD estdo lote , y disparao el even , actualizar sin refresh OK  

    // $this->subastaEstado = $event['estado'];
    // $this->lotes = $event['lotes'];
    // if ($this->subastaEstado === 'inactiva') {
    //     $this->error = 'La subasta ha finalizado';
    // }


    $this->loadLotes();
    // $this->test = "22";
    info("REVERT  XXXX");
    // info(["lotes " => $event['lotes']]);
    // info(["subata estado " => $event['estado']]);
    // dd("aaaa");

  }

  public function mount(Subasta $subasta)
  {
    info("lotees actuvis ");
    // info(["subasta" => $subasta]);
    $this->subasta = Subasta::find(9);
    // $this->subasta = $subasta;

    $this->loadLotes();
  }

  public function loadLotes()
  {
    // info(["lotexxxxsClass" => $this->lotes]);
    try {
      $this->lotes = app(SubastaService::class)->getLotesActivos($this->subasta)->toArray();
      info(["lotesClass" => $this->lotes]);
      $this->error = null;
    } catch (\Exception $e) {
      // info(["error" => $this-}>lotes]);
      info(["errorrrr" => $e->getMessage()]);
      $this->lotes = [];
      $this->error = $e->getMessage();
    }
  }

  public function registrarPuja($loteId, $monto)
  {
    $lote = $this->subasta->lotesActivos()->where('lotes.id', $loteId)->first();
    $contratoLote = $lote->contratoLotes()
      ->whereHas('contrato', fn($query) => $query->where('subasta_id', $this->subasta->id))
      ->first();

    if (!$this->subasta->isActiva() || !$contratoLote || !$contratoLote->isActivo()) {
      $this->addError('puja', 'Subasta o lote inactivo');
      return;
    }
    // 'adquirente_id' => auth()->id(),

    Puja::create([
      'adquirente_id' => 2,
      'lote_id' => $lote->id,
      'subasta_id' => $this->subasta->id,
      'monto' => $monto,
    ]);

    if (now()->gt($this->subasta->fecha_fin)) {
      $contratoLote->update(['tiempo_post_subasta_fin' => now()->addMinutes($this->subasta->tiempo_post_subasta)]);
    }

    //   event(new \App\Events\PujaRealizada(null, $this->subasta, $lote));
    //   $this->loadLotes(); // Recargar lotes después de la puja



  }

  // #[On('echo:subasta.{subasta.id},PujaRealizada')]
  // public function actualizarLote($event)
  // {
  //   foreach ($this->lotes as &$lote) {
  //     if ($lote['id'] == $event['lote_id']) {
  //       $lote['puja_actual'] = $event['monto'];
  //       $lote['tiempo_post_subasta_fin'] = $event['tiempo_post_subasta_fin'];
  //       $lote['estado'] = $event['estado'];
  //       break;
  //     }
  //   }
  // }

  public function render()
  {

    return view('livewire.lotes-activos');
  }
}
