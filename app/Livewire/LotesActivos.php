<?php

namespace App\Livewire;

use App\Livewire\Traits\WithSearchAndPagination;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Component;


class LotesActivos extends Component
{
  use WithSearchAndPagination;


  protected $subastaService;

  public $modalPago;
  public $adquirente;
  public $monedas;
  public Subasta $subasta;

  public $error = null;


  protected function fetchData($search, $page)
  {
    return app(SubastaService::class)->getLotesActivos(
      $this->subasta,
      $search,
      $search ? true : false, // ejemplo de lógica condicional
      $page,
      $this->perPage
    );
  }


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
  }


  public function getMonedaSigno($id)
  {
    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
  }



  public function mount(Subasta $subasta)
  {

    $this->adquirente = auth()->user()?->adquirente;
    // info(["porametro " => $this->searchParam]);
    // $this->subastaService = $subastaService;
    $this->subasta = $subasta;

    $this->monedas = Moneda::all();


    $now = now();
    if ($this->subasta->estado === 'activa' && $now->between($this->subasta->fecha_inicio, $this->subasta->fecha_fin)) {
      if ($this->searchParam) {
        $this->filtrar($this->searchParam);
        $this->search = $this->searchParam;
        // $this->dispatch("searchValue", $this->searchParam);
      } else {
        $this->loadLotes();
      }
    } elseif ($this->subasta->estado === 'enpuja') {
      $this->loadLotes();
    } else {
      info("mount444 ");
      $this->lotes = [];
    }
  }



  public function loadLotes()
  {
    $search = $this->fallbackAll ? null : $this->search;
    $conCaracteristicas = ! empty($this->search);

    $paginator = app(SubastaService::class)->getLotesActivos(
      $this->subasta,
      $search,
      $conCaracteristicas,
      $this->page,
      $this->perPage
    );

    $items = collect($paginator->items())->map(fn($lote) => [
      'id' => $lote->id,
      'titulo' => $lote->titulo,
      'foto' => $lote->foto1,
      'descripcion' => $lote->descripcion,
      'precio_base' => $lote->precio_base,
      'puja_actual' => $lote->pujas->first()?->monto,
      'tiempo_post_subasta_fin' => $lote->tiempo_post_subasta_fin,
      'moneda_id' => $lote->moneda_id,
      // 'tienePujas' => (bool) $lote->pujas_exists,
      'tienePujas' => (bool) $lote->pujas->isNotEmpty(),
    ])->toArray();

    $this->lotes = array_merge($this->lotes, $items);
    $this->hasMore = $paginator->hasMorePages();
    if ($this->filtered) {
      $this->filtered = count($this->lotes);
    }
  }


  public function render()
  {

    return view('livewire.lotes-activos');
  }
}
