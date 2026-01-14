<?php

namespace App\Livewire;

use App\Models\Moneda;
use App\Services\SubastaService;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;


class LotesSearch extends Component
{

  #[Url]
  public $searchParam = ''; //

  #[Url]
  public $from;

  public $existFrom;


  public $monedas;
  public $search;
  public $filtered;
  public $lotes = [];


  public int $page = 1;
  public int $perPage = 6;
  public bool $hasMore = false;

  public function getMonedaSigno($id)
  {
    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
  }


  public function mount()
  {

    $this->monedas = Moneda::all();

    $this->search = $this->searchParam;

    if ($this->search) {
      $this->filtrar($this->search);
    }

    if ($this->from) {
      $this->existFrom = Route::has($this->from);
    }
  }






  public function loadMore()
  {
    if (! $this->hasMore) return;

    $this->page++;

    $paginator = app(SubastaService::class)->buscarLotes(
      $this->search,
      $this->page,
      $this->perPage
    );

    $this->appendPaginator($paginator);
    $this->filtered = count($this->lotes);
  }





  #[On('buscarLotes')]
  public function filtrar($search = null)
  {
    $this->search = trim($search ?? $this->search);
    $this->searchParam = $this->search;

    $this->resetSearchState();

    if (strlen($this->search) < 3) {
      $this->hasMore = false;
      return;
    }


    $paginator = app(SubastaService::class)->buscarLotes(
      $this->search,
      1,
      $this->perPage
    );


    if ($paginator->count()  ==  0) {
      $this->filtered = 0;
      $this->lotes = [];
      $this->hasMore = false;
      return;
    }



    $this->filtered = $paginator->count();
    $this->appendPaginator($paginator);
  }


  protected function appendPaginator($paginator)
  {

    $items = collect($paginator->items())
      ->map(fn($lote) => [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'descripcion' => $lote->descripcion,
        'foto' => $lote->foto1,
        'precio_base' => $lote->precio_base,
        'moneda_id' => $lote->moneda_id,
        'tipo' => $this->resolverTipo($lote),
        'tienePujas' => (bool) $lote->tiene_pujas,
        'puja_actual' => $lote->puja_actual,
      ])
      ->values()
      ->toArray();

    $this->lotes = array_merge($this->lotes, $items);
    $this->hasMore = $paginator->hasMorePages();
  }

  protected function resolverTipo($lote): string
  {
    $now = now();

    if (in_array($lote->subasta_estado, ['activa', 'enpuja'])) {
      return 'activo';
    }

    if ($lote->fecha_inicio > $now) {
      return 'proximo';
    }

    return 'finalizado';
  }


  protected function resetSearchState()
  {
    $this->page = 1;
    $this->lotes = [];
    $this->hasMore = true;
    $this->filtered = null;
  }


  public function render()
  {

    return view('livewire.lotes-search');
  }
}
