<?php

namespace App\Livewire;

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
use MercadoPago\Client\Payment\PaymentRefundClient;
use MercadoPago\MercadoPagoConfig;


class LotesActivos extends Component
{


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
  public $lotes = [];
  public $error = null;
  public $subastaEstado = "11";

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



  public function mount(Subasta $subasta, SubastaService $subastaService)
  {
    info("mount ");

    $this->adquirente = auth()->user()?->adquirente;
    // info(["porametro " => $this->searchParam]);
    $this->subastaService = $subastaService;
    $this->subasta = $subasta;

    $this->monedas = Moneda::all();


    $now = now();
    if ($this->subasta->estado === 'activa' && $now->between($this->subasta->fecha_inicio, $this->subasta->fecha_fin)) {
      if ($this->searchParam) {
        $this->filtrar($this->searchParam, $subastaService);
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
    try {

      $this->lotes = $this->subastaService?->getLotesActivos($this->subasta)?->toArray();
      // info(["lotesClassLODAAAAAAAAAA" => $this->lotes]);

      $this->error = null;
    } catch (\Exception $e) {

      // info(["error" => $this-}>lotes]);
      info(["errorrrr99999999999999999999999999999999" => $e->getMessage()]);
      $this->lotes = [];
      $this->error = $e->getMessage();
    }
  }

  public function todos(SubastaService $subastaService)
  {
    $this->subastaService = $subastaService;
    $this->loadLotes();
    $this->filtered = null;
    $this->searchParam = null;
    $this->dispatch("clearSearch");
  }



  #[On(['buscarLotes'])]
  public function filtrar($search, SubastaService $subastaService)
  {
    // Guardar el término de búsqueda
    $this->search = is_string($search) ? trim($search) : '';

    // Siempre obtener TODOS los lotes frescos del servicio para buscar desde cero
    $todosLosLotes = $subastaService?->getLotesActivos($this->subasta, true)?->toArray() ?? [];

    // Si no hay término de búsqueda, mostrar todos los lotes
    if (empty($this->search)) {
      $this->lotes = $todosLosLotes;
      $this->noSearch = false;
      return;
    }

    // Filtrar desde TODOS los lotes, no desde los ya filtrados
    $searchLower = strtolower($this->search);

    $filteredLotes2 = collect($todosLosLotes)->filter(function ($lote) use ($searchLower) {
      return str_contains(strtolower($lote['titulo'] ?? ''), $searchLower)
        || str_contains(strtolower($lote['descripcion'] ?? ''), $searchLower);
    })->values()->toArray();

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
    info(["lotes new" => $this->lotes]);
  }



  // #[On('echo:subasta.{subasta.id},PujaRealizada')]
  // public function actualizarLote($event)
  // {
  //   foreach ($this->lotes as &$lote) {
  //     if ($lote['id'] == $event['lote_id']) {
  //       $lote['puja_actual'] = $event['monto'];
  //       $lote['tiempo_post_subasta_fin'] = $event['tiempo_post_subasta_fin'];
  //       $lote['estado'] = $event['estado'];
  //       break;
  //     }
  //   }
  // }




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
