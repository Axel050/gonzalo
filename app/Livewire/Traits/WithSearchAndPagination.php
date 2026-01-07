<?php

namespace App\Livewire\Traits;

use App\DTOs\PaginatedLotesDTO;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

trait WithSearchAndPagination
{

  // Propiedades comunes
  #[Url()]
  public $searchParam = '';
  public $search = '';
  public $noSearch = false;
  public $filtered = null;
  public $fallbackAll = false;
  public $page = 1;
  public $lotes = [];
  public $hasMore = true;
  public $perPage = 6;

  /**
   * Este método debe ser definido en el componente para 
   * indicar qué método del servicio llamar.
   */

  abstract protected function searchType(): string;

  abstract protected function fetchData($search, $page);

  public function todos()
  {
    $this->resetSearchState();
    $this->search = '';
    $this->searchParam = '';
    $this->dispatch("clearSearch");
    $this->loadLotes();
  }

  #[On('buscarLotes')]
  public function filtrar($search)
  {
    $this->search = trim($search);
    $this->searchParam = $this->search;

    $this->resetSearchState();

    // Llamada dinámica mediante el método abstracto
    $paginator = $this->fetchData($this->search, 1);

    // ✅ Hay resultados
    if ($paginator->count() > 0) {
      $this->filtered = $paginator->count();
      $this->appendPaginator($paginator);
      return;
    }

    // ❌ Sin resultados (Fallback)
    $this->noSearch = true;
    $this->fallbackAll = true;

    $paginator = $this->fetchData(null, 1);
    $this->appendPaginator($paginator);
  }



  protected function appendPaginator($paginator)
  {
    $dto = PaginatedLotesDTO::fromPaginator(
      $paginator,
      $this->searchType()
    );

    $this->lotes   = array_merge($this->lotes, $dto->data);
    $this->hasMore = $dto->has_more;
  }



  protected function appendPaginator2($paginator)
  {
    $type = $this->searchType();


    $items = collect($paginator->items())->map(function ($lote) use ($type) {
      $data = [
        'id' => $lote->id,
        'titulo' => $lote->titulo,
        'foto' => $lote->foto1,
        'descripcion' => $lote->descripcion,
        'precio_base' => $lote->precio_base,
        'moneda_id' => $lote->moneda_id,

      ];

      if ($type === 'estado' || $type === 'completo') {

        $data['estado'] = $lote->estado;
      }


      if ($type === 'pujas' || $type === 'completo') {

        $data['puja_actual'] = $lote->pujas->first()?->monto;
        $data['tienePujas'] = (bool) $lote->pujas_exists;
      }

      return $data;
    })->toArray();

    $this->lotes = array_merge($this->lotes, $items);
    $this->hasMore = $paginator->hasMorePages();
  }



  protected function resetSearchState()
  {

    $this->page = 1;
    $this->lotes = [];
    $this->hasMore = true;
    $this->filtered = null;
    $this->noSearch = false;
    $this->fallbackAll = false;
  }


  public function loadMore()
  {
    if (!$this->hasMore) return;

    $this->page++;
    $searchTerm = $this->fallbackAll ? null : $this->search;

    $paginator = $this->fetchData($searchTerm, $this->page);

    // IMPORTANTE: Llamar al método que tiene los IF del searchType
    $this->appendPaginator($paginator);
  }



  public function getMonedaSigno($id)
  {
    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
  }
}
