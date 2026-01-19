<?php

namespace App\Livewire;

use App\DTOs\PaginatedLotesDTO;
use App\Livewire\Traits\WithSearchAndPagination;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;


class LotesActivos extends Component
{
  use WithSearchAndPagination;


  protected $subastaService;

  public $modalPago;
  public $adquirente;
  public $monedas;

  #[Locked]
  public Subasta $subasta;

  public $error = null;

  protected function searchType(): string
  {
    return 'pujas'; // Solo cargará campos de pujas
  }


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





  public function mount(Subasta $subasta)
  {

    $user  = Auth::user();

    $this->adquirente = $user?->adquirente;


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

      $this->hasMore = false;
      $this->lotes = [];
    }
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

    if ($this->filtered !== null) {
      $this->filtered = count($this->lotes);
    }
  }

  public function render()
  {

    return view('livewire.lotes-activos');
  }
}
