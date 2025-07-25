<?php

namespace App\Livewire;

use App\Jobs\ActivarLotes;
use App\Jobs\DesactivarLotesExpirados;
use App\Models\Puja;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Component;

class LotesActivos extends Component
{
  protected $subastaService;

  public Subasta $subasta;
  public $lotes = [];
  public $error = null;
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

  public function activar()
  {
    info("ACTIVAR");
    $job = new ActivarLotes();
    $job->handle();
  }

  public function job()
  {
    $job = new DesactivarLotesExpirados();
    $job->handle();
  }



  public function mount(Subasta $subasta, SubastaService $subastaService)
  {
    info("mount ");
    $this->subastaService = $subastaService;
    $this->subasta = $subasta;

    $now = now();
    if ($this->subasta->estado === 'activa' && $now->between($this->subasta->fecha_inicio, $this->subasta->fecha_fin)) {
      $this->loadLotes();
    } elseif ($this->subasta->estado === 'enpuja') {
      $this->loadLotes();
    } else {
      info("mount444 ");
      $this->lotes = [];
    }
  }

  public function loadLotes()
  {
    try {
      info("lotesClass");

      $this->lotes = $this->subastaService?->getLotesActivos($this->subasta)?->toArray();
      // info(["lotesClass" => $this->lotes]);
      $this->error = null;
    } catch (\Exception $e) {
      // info(["error" => $this-}>lotes]);
      info(["errorrrr" => $e->getMessage()]);
      $this->lotes = [];
      $this->error = $e->getMessage();
    }
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
