<?php

namespace App\Livewire;

use App\Enums\SubastaEstados;
use App\Livewire\Traits\WithSearchAndPagination;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Component;


class LotesProximos extends Component
{
  use WithSearchAndPagination;


  public $modal;
  public $monedas;

  public Subasta $subasta;

  protected function searchType(): string
  {
    return false; // Solo cargará campos de pujas
  }

  protected function fetchData($search, $page)
  {
    return app(SubastaService::class)->getLotesProximos(
      $this->subasta,
      $search,
      $search ? true : false, // ejemplo de lógica condicional
      $page,
      $this->perPage
    );
  }



  public function mount(Subasta $subasta)
  {
    $this->subasta = $subasta;
    $this->monedas = Moneda::all();

    if (!empty($this->searchParam)) {
      $this->search = $this->searchParam;
      $this->filtrar($this->searchParam);
    } else {
      $this->loadLotes();
    }
  }

  // public function updatingSearch()
  // {
  //   $this->resetPage(); // 
  // }

  #[On('echo:my-channel,SubastaEstadoActualizado')]
  public function actualizarEstado($event)
  {

    if ($this->subasta->estado == SubastaEstados::ACTIVA) {
      $this->modal = 1;
      $this->lotes = [];
    }
  }


  public function continuar()
  {
    return redirect()->route('subasta.lotes', $this->subasta->id);
  }





  public function loadLotes()
  {
    $search = $this->fallbackAll ? null : $this->search;
    $conCaracteristicas = !empty($this->search);


    $paginator = app(SubastaService::class)->getLotesProximos(
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
      'moneda_id' => $lote->moneda_id,
    ])->toArray();

    $this->lotes = array_merge($this->lotes, $items);
    $this->hasMore = $paginator->hasMorePages();
    if ($this->filtered) {
      $this->filtered = count($this->lotes);
    }
  }





  public function render()
  {

    return view('livewire.lotes-proximos');
  }
}
