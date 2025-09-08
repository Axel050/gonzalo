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
use MercadoPago\Client\Payment\PaymentRefundClient;
use MercadoPago\MercadoPagoConfig;


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


  public function mount(Subasta $subasta, SubastaService $subastaService)
  {
    info("mountxxxaaa ");
    $this->subastaService = $subastaService;
    $this->subasta = $subasta;

    $this->monedas = Moneda::all();

    $now = now();
    // if ($this->estado === SubastaEstados::INACTIVA && $now->lessThan($this->fecha_inicio)) {
    // if ($this->subasta->estado === 'inactiva' && $now->between($this->subasta->fecha_inicio, $this->subasta->fecha_fin)) {
    if ($this->subasta->estado === SubastaEstados::FINALIZADA && $now->greaterThan($this->subasta->fecha_fin)) {
      if ($this->searchParam) {
        $this->filtrar($this->searchParam, $subastaService);
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

  public function loadLotes()
  {
    info("lotesClassxxx");
    try {
      info("lotesClass");

      $this->lotes = $this->subastaService?->getLotesPasados($this->subasta)?->toArray();
      info(["lotesCl8888ass" => $this->lotes]);
      $this->error = null;
    } catch (\Exception $e) {
      // info(["error" => $this-}>lotes]);
      info(["errorrrr" => $e->getMessage()]);
      $this->lotes = [];
      $this->error = $e->getMessage();
    }
  }

  #[On(['buscarLotes'])]
  public function filtrar($search, SubastaService $subastaService)
  {
    // Guardar el término de búsqueda
    $this->search = is_string($search) ? trim($search) : '';

    // Siempre obtener TODOS los lotes frescos del servicio para buscar desde cero
    $todosLosLotes = $subastaService?->getLotesPasados($this->subasta)?->toArray() ?? [];

    // Si no hay término de búsqueda, mostrar todos los lotes
    if (empty($this->search)) {
      $this->lotes = $todosLosLotes;
      $this->noSearch = false;
      return;
    }

    // Filtrar desde TODOS los lotes, no desde los ya filtrados
    $searchLower = strtolower($this->search);
    $filteredLotes = collect($todosLosLotes)->filter(function ($lote) use ($searchLower) {
      return str_contains(strtolower($lote['titulo'] ?? ''), $searchLower)
        || str_contains(strtolower($lote['descripcion'] ?? ''), $searchLower);
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

  public function todos(SubastaService $subastaService)
  {
    $this->subastaService = $subastaService;
    $this->loadLotes();
    $this->filtered = null;
    $this->searchParam = null;
    $this->dispatch("clearSearch");
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
    $preference = $mpService->crearPreferencia("Deposito", 1, 300, 5, 6);

    // info(["PPPP" => $preference]);
  }



  public function crearDevolucion(MPService $mpService)
  {
    info("CREEEEE");
    try {
      $de = $mpService->crearDevolucion(21);
      //code...
    } catch (\Throwable $th) {
      //throw $th;
      info(["EERRROORRR"  => $th]);
    }
  }






  public function render()
  {

    return view('livewire.lotes-pasados');
  }
}
