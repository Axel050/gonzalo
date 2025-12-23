<?php

namespace App\Livewire;

use App\Jobs\ActivarLotes;
use App\Jobs\DesactivarLotesExpirados;
use App\Livewire\Traits\WithSearchAndPagination;
use App\Models\Garantia;
use App\Models\Moneda;
use App\Models\Puja;
use App\Models\Subasta;
use App\Services\MPService;
use App\Services\SubastaService;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use MercadoPago\Client\Payment\PaymentRefundClient;
use MercadoPago\MercadoPagoConfig;


class LotesActivos extends Component
{
  use WithSearchAndPagination;

  #[Url]
  public $searchParam = ''; //


  protected $subastaService;

  public $modalPago;
  public $adquirente;
  public $te;

  public $noSearch;
  public $search;
  public $filtered;
  public $monedas;
  public Subasta $subasta;
  // public $lotes = [];
  public $error = null;
  public $subastaEstado = "11";


  public int $page = 1;
  public int $perPage = 6;

  public array $lotes = [];
  public bool $hasMore = true;
  public bool $fallbackAll = false;


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


  public function getMonedaSigno($id)
  {
    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
  }

  public function aaa()
  {

    $this->dispatch('saved');
  }



  public function mount(Subasta $subasta)
  {
    info("mount ");
    info("mounxxxxxxxxxxxxxxxxxxxxxxxxst ");

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


  public function loadMore()
  {
    if (! $this->hasMore) {
      return;
    }

    $this->page++;
    $this->loadLotes();
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




  #[On('buscarLotes')]
  public function filtrar($search)
  {
    $this->search = trim($search);
    $this->searchParam = $this->search;

    // reset
    $this->page = 1;
    $this->lotes = [];
    $this->hasMore = true;
    $this->filtered = null;
    $this->noSearch = false;
    $this->fallbackAll = false;


    $paginator = app(SubastaService::class)->getLotesActivos(
      $this->subasta,
      $this->search,
      true,
      1,
      $this->perPage
    );

    // ✅ hay resultados
    if ($paginator->count() > 0) {
      $this->filtered = $paginator->count();
      $this->appendPaginator($paginator);
      return;
    }

    // ❌ sin resultados
    $this->noSearch = true;
    $this->fallbackAll = true;

    $paginator = app(SubastaService::class)->getLotesActivos(
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
      'puja_actual' => $lote->pujas->first()?->monto,
      'moneda_id' => $lote->moneda_id,
      'tienePujas' => (bool) $lote->pujas_exists,
    ])->toArray();

    $this->lotes = array_merge($this->lotes, $items);
    $this->hasMore = $paginator->hasMorePages();
  }










  public function mp(MPService $mpService)
  {



    $this->modalPago = 1;
  }

  public function mp2(MPService $mpService)
  {


    $route = "/subastas/" . $this->subasta->id . "/lotes";;

    $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente->id, $this->subasta->id, null,  $route);

    if ($preference) {
      // $this->init = $preference->init_point;
      return redirect()->away($preference->init_point);
    }
    // info(["PPPP" => $preference]);
  }



  public function render()
  {

    return view('livewire.lotes-activos');
  }
}
