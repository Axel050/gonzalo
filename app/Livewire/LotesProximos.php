<?php

namespace App\Livewire;

use App\DTOs\PaginatedLotesDTO;
use App\Enums\SubastaEstados;
use App\Livewire\Traits\WithSearchAndPagination;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;


class LotesProximos extends Component
{
  use WithSearchAndPagination;


  public $modal;
  public $monedas;

  #[Locked]
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
    $paginator = $this->fetchData(
      $this->fallbackAll ? null : $this->search,
      $this->page
    );

    $dto = PaginatedLotesDTO::fromPaginator(
      $paginator,
      $this->searchType()
    );

    $this->lotes   = array_merge($this->lotes, $dto->data);
    $this->hasMore = $dto->has_more;
    info(["LOTES PROXIMOS" => $this->lotes]);

    if ($this->filtered !== null) {
      $this->filtered = count($this->lotes);
    }
  }



  public function render()
  {

    return view('livewire.lotes-proximos');
  }
}
