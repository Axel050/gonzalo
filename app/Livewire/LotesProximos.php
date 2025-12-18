<?php

namespace App\Livewire;

use App\Enums\SubastaEstados;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Url;


class LotesProximos extends Component
{

  #[Url()]
  public string $searchParam = '';


  public string $search = '';

  public string $searchx = '';
  public $noSearch;
  public $modal;
  public $filtered;
  public $monedas;


  public int $page = 1;
  public int $perPage = 6;

  public array $lotes = [];
  public bool $hasMore = true;
  public bool $fallbackAll = false;


  public Subasta $subasta;


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


  #[On('buscarLotes')]
  public function filtrar($search)
  {
    $this->search = trim($search);
    $this->searchParam = $this->search;

    // Reset total
    $this->page = 1;
    $this->lotes = [];
    $this->filtered = null;
    $this->noSearch = false;
    $this->hasMore = true;
    $this->fallbackAll = false;

    // 🔍 Buscar con filtro
    $paginator = app(SubastaService::class)->getLotesProximos(
      $this->subasta,
      $this->search,
      true,          // características solo si hay búsqueda
      1,
      $this->perPage
    );

    // ✅ CASO 1: hay resultados
    if ($paginator->count() > 0) {
      $this->filtered = $paginator->count(); // puede ser null si usás simplePaginate
      $this->appendPaginator($paginator);
      return;
    }

    // ❌ CASO 2: NO hay resultados
    $this->noSearch = true;
    $this->fallbackAll = true;
    // Traer TODOS los lotes sin filtro
    $paginator = app(SubastaService::class)->getLotesProximos(
      $this->subasta,
      null,
      false,
      1,
      $this->perPage
    );

    $this->appendPaginator($paginator);
  }




  protected function appendPaginator($paginator)
  {
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
  }




  public function todos()
  {
    $this->search = '';
    $this->searchParam = '';
    $this->noSearch = false;
    $this->filtered = null;
    $this->fallbackAll = false;
    $this->page = 1;
    $this->lotes = [];
    $this->hasMore = true;
    $this->dispatch("clearSearch");

    $this->loadLotes();
  }







  public function getMonedaSigno($id)
  {
    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
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


  public function loadMore()
  {
    if (! $this->hasMore) {
      return;
    }

    $this->page++;
    $this->loadLotes();
  }



  public function render()
  {

    return view('livewire.lotes-proximos');
  }
}
