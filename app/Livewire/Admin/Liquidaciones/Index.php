<?php

namespace App\Livewire\Admin\Liquidaciones;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Liquidacion;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
  use WithPagination;

  public $query;

  public $dateFrom;

  public $dateTo;

  public $searchType = 'todos';

  public $method = '';

  public $id;

  public $tab = 'liquidaciones';

  public $comitente_id_selected = null;

  public function updatingQuery()
  {
    $this->resetPage();
  }

  public function updatingDateFrom()
  {
    $this->resetPage();
  }

  public function updatingDateTo()
  {
    $this->resetPage();
  }


  public function setTab($tabName)
  {
    $this->tab = $tabName;
    $this->query = '';
    $this->resetPage();
  }

  public function option($method, $id = false, $comitente_id = null)
  {
    $this->method = $method;
    $this->id = $id;
    $this->comitente_id_selected = $comitente_id;
  }

  #[On(['liquidacionCreated', 'liquidacionesGenerated'])]
  public function close()
  {
    $this->method = '';
    $this->comitente_id_selected = null;
    $this->resetPage();
  }

  public function anular($id, \App\Services\LiquidacionService $liquidacionService)
  {
    $liquidacionService->anularLiquidacion($id);
    $this->method = '';
    $this->dispatch('liquidacionUpdated');
  }

  public function render()
  {
    $pendientesCount = Comitente::whereHas('Clotes', function ($q) {
      $q->where('estado', LotesEstados::FACTURADO);
    })->count();

    if ($this->tab === 'liquidaciones') {
      $liquidacionesQuery = Liquidacion::with(['comitente', 'asociadas', 'items', 'asociadas.items'])->whereNull('liquidacion_asociada_id');

      if ($this->query) {
        switch ($this->searchType) {
          case 'id':
            $liquidacionesQuery->where('id', 'like', '%' . $this->query . '%');
            break;
          case 'comitente':
            $liquidacionesQuery->whereHas('comitente', function ($q) {
              $q->where('nombre', 'like', '%' . $this->query . '%')
                ->orWhere('apellido', 'like', '%' . $this->query . '%')
                ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%' . $this->query . '%']);
            });
            break;
          case 'todos':
            $liquidacionesQuery->where(function ($q) {
              $q->where('id', 'like', '%' . $this->query . '%')
                ->orWhereHas('comitente', function ($query) {
                  $query->where('nombre', 'like', '%' . $this->query . '%')
                    ->orWhere('apellido', 'like', '%' . $this->query . '%')
                    ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%' . $this->query . '%']);
                });
            });
            break;
        }
      }

      if ($this->dateFrom) {
        $liquidacionesQuery->whereDate('fecha', '>=', $this->dateFrom);
      }

      if ($this->dateTo) {
        $liquidacionesQuery->whereDate('fecha', '<=', $this->dateTo);
      }

      $mainIds = (clone $liquidacionesQuery)->where('estado', '!=', 'anulada')->pluck('id');
      $asociadasQuery = Liquidacion::whereIn('liquidacion_asociada_id', $mainIds)->where('estado', '!=', 'anulada');

      $global_lotes = (clone $liquidacionesQuery)->where('estado', '!=', 'anulada')->sum('subtotal_lotes') + (clone $asociadasQuery)->sum('subtotal_lotes');
      $global_deducciones = (clone $liquidacionesQuery)->where('estado', '!=', 'anulada')->sum('subtotal_comisiones') + (clone $liquidacionesQuery)->where('estado', '!=', 'anulada')->sum('subtotal_gastos') + (clone $asociadasQuery)->sum('subtotal_comisiones') + (clone $asociadasQuery)->sum('subtotal_gastos');
      $global_total = (clone $liquidacionesQuery)->where('estado', '!=', 'anulada')->sum('monto_total') + (clone $asociadasQuery)->sum('monto_total');

      $liquidaciones = $liquidacionesQuery->orderBy('id', 'desc')->paginate(15);

      return view('livewire.admin.liquidaciones.index', [
        'liquidaciones' => $liquidaciones,
        'comitentes_pendientes' => null,
        'pendientesCount' => $pendientesCount,
        'global_lotes' => $global_lotes,
        'global_deducciones' => $global_deducciones,
        'global_total' => $global_total,
      ]);
    } else {
      $query = Comitente::query();

      if ($this->query) {
        $query->where(function ($q) {
          $q->where('nombre', 'like', '%' . $this->query . '%')
            ->orWhere('apellido', 'like', '%' . $this->query . '%')
            ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%' . $this->query . '%'])
            ->orWhere('id', $this->query);
        });
      }

      $comitentes_pendientes = $query->whereHas('Clotes', function ($q) {
        $q->where('estado', LotesEstados::FACTURADO);
      })->with(['Clotes' => function ($q) {
        $q->where('estado', LotesEstados::FACTURADO);
      }])->paginate(15);

      return view('livewire.admin.liquidaciones.index', [
        'liquidaciones' => null,
        'comitentes_pendientes' => $comitentes_pendientes,
        'pendientesCount' => $pendientesCount,
      ]);
    }
  }
}
