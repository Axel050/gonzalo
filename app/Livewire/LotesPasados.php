<?php

namespace App\Livewire;

use App\Enums\SubastaEstados;
use App\Jobs\ActivarLotes;
use App\Jobs\DesactivarLotesExpirados;
use App\Models\Garantia;
use App\Models\Moneda;
use App\Models\Puja;
use App\Models\Subasta;
use App\Services\MPService;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;


class LotesPasados extends Component
{
  #[Url()]
  public $searchParam = ''; //
  public $noSearch;
  public $search;
  public $filtered;

  protected $subastaService;

  public $monedas;
  public Subasta $subasta;
  // public $lotes = [];
  public $error = null;
  public $subastaEstado = "11";

  public array $lotes = [];
  public int $page = 1;
  public int $perPage = 6;
  public bool $hasMore = true;
  public bool $fallbackAll = false;


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



  public function getMonedaSigno($id)
  {
    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
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
      info("mount444 8888");
      $this->lotes = [];
    }
  }

  public function loadLoteeees()
  {
    info("lotesClassxxx");
    try {
      info("lotesClass");

      $this->lotes = $this->subastaService?->getLotesPasados($this->subasta)?->toArray();
      // info(["lotesCl8888ass" => $this->lotes]);
      $this->error = null;
    } catch (\Exception $e) {
      // info(["error" => $this-}>lotes]);
      info(["errorrrr" => $e->getMessage()]);
      $this->lotes = [];
      $this->error = $e->getMessage();
    }
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

    $paginator = app(SubastaService::class)->getLotesPasados(
      $this->subasta,
      $this->search,
      true,          // características solo si hay búsqueda
      1,
      $this->perPage
    );

    if ($paginator->count() > 0) {
      $this->filtered = $paginator->count(); // puede ser null si usás simplePaginate
      $this->appendPaginator($paginator);
      return;
    }

    $this->noSearch = true;
    $this->fallbackAll = true;
    // Traer TODOS los lotes sin filtro
    $paginator = app(SubastaService::class)->getLotesPasados(
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
      'estado_lote' => $lote->estado_lote,
    ])->toArray();

    $this->lotes = array_merge($this->lotes, $items);
    $this->hasMore = $paginator->hasMorePages();
  }


  public function loadLotes()
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
      'estado_lote' => $lote->lote_estado,
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


  #[On(['buscarLotsses'])]
  public function filtrsssar($search, SubastaService $subastaService)
  {
    // Guardar el término de búsqueda
    $this->search = is_string($search) ? trim($search) : '';

    // Siempre obtener TODOS los lotes frescos del servicio para buscar desde cero
    $todosLosLotes = $subastaService?->getLotesPasados($this->subasta, true)?->toArray() ?? [];

    // Si no hay término de búsqueda, mostrar todos los lotes
    if (empty($this->search)) {
      $this->lotes = $todosLosLotes;
      $this->noSearch = false;
      return;
    }

    // Filtrar desde TODOS los lotes, no desde los ya filtrados
    $searchLower = strtolower($this->search);

    $filteredLotes = collect($todosLosLotes)->filter(function ($lote) use ($searchLower) {
      $tituloMatch = str_contains(strtolower($lote['titulo'] ?? ''), $searchLower);
      $descripcionMatch = str_contains(strtolower($lote['descripcion'] ?? ''), $searchLower);

      // Buscar en características
      $caracteristicasMatch = collect($lote['caracteristicas'] ?? [])
        ->contains(function ($valor) use ($searchLower) {
          return str_contains(strtolower($valor), $searchLower);
        });

      return $tituloMatch || $descripcionMatch || $caracteristicasMatch;
    })->values()->toArray();


    // Si hay coincidencias, mostrar solo los filtrados
    if (!empty($filteredLotes)) {
      $this->lotes = $filteredLotes;
      $this->noSearch = false;
      $this->filtered  = count($filteredLotes);
    } else {
      // Si no hay coincidencias, mantener todos los lotes pero mostrar mensaje
      $this->lotes = $todosLosLotes;
      $this->noSearch = true;
      $this->filtered  = null;
    }

    info('Búsqueda realizada', [
      'término' => $this->search,
      'total_lotes' => count($todosLosLotes),
      'coincidencias' => count($filteredLotes),
      'mostrando' => $this->noSearch ? 'todos con mensaje' : 'solo filtrados'
    ]);
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






  public function render()
  {

    return view('livewire.lotes-pasados');
  }
}
