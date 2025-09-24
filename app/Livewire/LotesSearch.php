<?php

namespace App\Livewire;

use App\Enums\LotesEstados;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

  public $te;

  public $noSearch;
  public $search;
  public $filtered;
  public $monedas;
  public Subasta $subasta;
  public $lotes = [];
  public $error = null;
  public $subastaEstado = "11";



  public function getMonedaSigno($id)
  {
    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
  }


  public function mount()
  {

    // dd("MIRAR   DIFERECNIA DE BUSCADOR EN DONDE MUESTRA ; CONFLICTO CON EL URL QUERY ");
    info("mount ");


    // info(["porametro " => $this->searchParam]);    
    $this->subasta = Subasta::find(1);

    $this->monedas = Moneda::all();


    $this->search = $this->searchParam;
    // IDs

    if ($this->search) {
      info("MOUNT///////");
      $this->filtrar();
    }

    if ($this->from) {
      $this->existFrom = Route::has($this->from);
    }

    // info(["resutls555555" => $this->lotes]);
  }


  #[On(['buscarLotes'])]
  public function filtrar($search = null)
  {
    if ($search) {
      $this->search = $search;
      $this->searchParam = $search;
    }

    // Tipos de subastas
    $idsSubastasAct  = Subasta::whereIn('estado', ["activa", "enpuja"])->pluck('id');
    $idsSubastasProx = Subasta::where('fecha_inicio', '>=', Carbon::now())->pluck('id');
    $idsSubastasFin  = Subasta::where('estado', "finalizada")->pluck('id');


    // Función genérica para obtener lotes
    $getLotes = function ($idsSubastas, $estadoLote, $tipo) {
      return Lote::query()
        ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
        ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
        ->leftJoin(DB::raw('(
                SELECT p1.lote_id, p1.monto as puja_actual
                FROM pujas p1
                INNER JOIN (
                    SELECT lote_id, MAX(id) as max_id
                    FROM pujas
                    GROUP BY lote_id
                ) p2 ON p1.lote_id = p2.lote_id AND p1.id = p2.max_id
            ) as p'), 'lotes.id', '=', 'p.lote_id')
        ->whereIn('contratos.subasta_id', $idsSubastas)
        // ->where('lotes.estado', $estadoLote)
        ->where('contrato_lotes.estado', 'activo')
        ->whereColumn('lotes.ultimo_contrato', 'contratos.id')
        ->when($this->search, function ($q) {
          $q->where(function ($q2) {
            $q2->where('lotes.titulo', 'like', '%' . $this->search . '%')
              ->orWhere('lotes.descripcion', 'like', '%' . $this->search . '%');
          });
        })
        ->select(
          'lotes.id as lote_id',
          'lotes.titulo',
          'lotes.descripcion',
          'lotes.foto1',
          'lotes.valuacion',
          'lotes.estado as lote_estado',
          'contrato_lotes.precio_base as base',
          'contrato_lotes.moneda_id',
          'contrato_lotes.estado as contrato_lote_estado',
          'contrato_lotes.id as contrato_lote_id',
          'contratos.subasta_id',
          'p.puja_actual'
        )
        ->get()
        ->map(function ($lote) use ($tipo) {
          $lote->tipo = $tipo;
          return $lote;
        });
    };

    // Lotes por tipo
    $lotesActivos     = $getLotes($idsSubastasAct,  LotesEstados::EN_SUBASTA, 'activo');
    $lotesProximos    = $getLotes($idsSubastasProx, LotesEstados::ASIGNADO, 'proximo');
    $lotesFinalizados = $getLotes($idsSubastasFin,  LotesEstados::DISPONIBLE, 'finalizado');

    // Unimos y ordenamos
    // $this->lotes = $lotesActivos
    //   ->merge($lotesProximos)
    //   ->merge($lotesFinalizados)
    //   ->sortBy(function ($lote) {
    //     return $lote->tipo === 'activo' ? 0 : ($lote->tipo === 'proximo' ? 1 : 2);
    //   })
    //   ->values();

    $totalActivos     = $lotesActivos->count();
    $totalProximos    = $lotesProximos->count();
    $totalFinalizados = $lotesFinalizados->count();

    // $this->lotes = $lotesActivos
    //   ->merge($lotesProximos)
    //   ->merge($lotesFinalizados)
    //   ->sortBy(fn($lote) => $lote->tipo === 'activo' ? 0 : ($lote->tipo === 'proximo' ? 1 : 2))
    //   ->values();

    $merged = collect($lotesActivos)
      ->merge($lotesProximos)
      ->merge($lotesFinalizados)
      ->sortBy(fn($lote) => $lote->tipo === 'activo' ? 0 : ($lote->tipo === 'proximo' ? 1 : 2))
      ->values();

    // ahora sí contamos bien
    $this->filtered = $merged->count();

    // Livewire-friendly: pasamos a array solo al final
    $this->lotes = $merged->toArray();

    info([
      'Activos' => count($lotesActivos),
      'Próximos' => count($lotesProximos),
      'Finalizados' => count($lotesFinalizados),
      'Total Final' => $this->filtered
    ]);



    $this->filtered  = count($this->lotes);
  }





  public function render()
  {

    return view('livewire.lotes-search');
  }
}
