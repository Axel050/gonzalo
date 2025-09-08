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
      $this->filtrar();
    }

    if ($this->from) {
      $this->existFrom = Route::has($this->from);
    }

    // info(["resutls555555" => $this->lotes]);
  }



  #[On(['buscarLotes'])]
  public function filtrar($search = null,)
  {



    if ($search) {
      $this->search = $search;
      $this->searchParam = $search;
    }

    $subastasProx = Subasta::where('fecha_inicio', '>=', Carbon::now())->get();
    $subastasAct = Subasta::whereIn('estado', ["activa", "enpuja"])->get();
    $idsSubastasProx = $subastasProx->pluck('id');
    $idsSubastasAct  = $subastasAct->pluck('id');

    $lotesActivos = Lote::query()
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
      ->whereIn('contratos.subasta_id', $idsSubastasAct)
      ->where('lotes.estado', LotesEstados::EN_SUBASTA)
      ->where('contrato_lotes.estado', 'activo')
      ->when($this->search, function ($query) {
        $query->where(function ($q) {
          $q->where('lotes.titulo', 'like', '%' . $this->search . '%')
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
        'contrato_lotes.precio_base as base',   // 👈 Selección explícita
        'contrato_lotes.moneda_id',
        'contrato_lotes.estado as contrato_lote_estado',
        'contrato_lotes.id as contrato_lote_id',
        'contratos.subasta_id',
        'p.puja_actual'
      )
      ->get()
      ->map(function ($lote) {
        $lote->tipo = 'activo';
        return $lote;
      });



    // Lotes Próximos
    $lotesProximos = Lote::query()
      ->join('contrato_lotes', 'lotes.id', '=', 'contrato_lotes.lote_id')
      ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
      ->whereIn('contratos.subasta_id', $idsSubastasProx)
      ->where('lotes.estado', LotesEstados::ASIGNADO)
      ->where('contrato_lotes.estado', 'activo')
      ->when($this->search, function ($q) {
        $q->where(function ($q2) {
          $q2->where('lotes.titulo', 'like', '%' . $this->search . '%')
            ->orWhere('lotes.descripcion', 'like', '%' . $this->search . '%');
        });
      })
      ->select('lotes.*', 'contrato_lotes.*', 'contratos.subasta_id')
      ->get()
      ->map(function ($item) {
        $item->tipo = 'proximo';
        return $item;
      });

    // Unimos todo en una sola colección
    $lotes = $lotesActivos->merge($lotesProximos);

    // Ordenamos: primero activos, luego próximos
    $this->lotes = $lotes->sortBy(function ($lote) {
      return $lote->tipo === 'activo' ? 0 : 1;
    })->values();


    $this->filtered  = count($this->lotes);

    // info(["333333" => $this->lotes]);
  }



  public function render()
  {

    return view('livewire.lotes-search');
  }
}
