<?php

namespace App\Livewire;

use App\DTOs\PaginatedLotesDTO;
use App\Enums\SubastaEstados;
use App\Livewire\Traits\WithSearchAndPagination;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Component;


class LotesPasados extends Component
{

  use WithSearchAndPagination;


  public $monedas;
  public Subasta $subasta;
  public $error = null;



  protected function searchType(): string
  {
    return 'estado'; // Solo cargará campos de pujas
  }

  protected function fetchData($search, $page)
  {
    return app(SubastaService::class)->getLotesPasados(
      $this->subasta,
      $search,
      $search ? true : false, // ejemplo de lógica condicional
      $page,
      $this->perPage
    );
  }




  public function mount(Subasta $subasta)
  {
    info("mountxxxaaa ");
    // $this->subastaService = $subastaService;
    $this->subasta = $subasta;

    $this->monedas = Moneda::all();

    $now = now();
    // if ($this->estado === SubastaEstados::INACTIVA && $now->lessThan($this->fecha_inicio)) {
    // if ($this->subasta->estado === 'inactiva' && $now->between($this->subasta->fecha_inicio, $this->subasta->fecha_fin)) {
    if ($this->subasta->estado === SubastaEstados::FINALIZADA && $now->greaterThan($this->subasta->fecha_fin)) {
      if ($this->searchParam) {
        $this->filtrar($this->searchParam);
        $this->search = $this->searchParam;
        // $this->dispatch("searchValue", $this->searchParam);
      } else {
        $this->loadLotes();
      }
    } else {
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


  public function loadLotes2()
  {
    if (! $this->hasMore) {
      return;
    }

    $search = $this->fallbackAll ? null : $this->search;
    $conCaracteristicas = !empty($this->search);

    $paginator = app(SubastaService::class)->getLotesPasados(
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
      'estado' => $lote->estado,
    ])->toArray();

    $this->lotes = array_merge($this->lotes, $items);
    $this->hasMore = $paginator->hasMorePages();
    if ($this->filtered) {
      $this->filtered = count($this->lotes);
    }
  }







  public function render()
  {

    return view('livewire.lotes-pasados');
  }
}
