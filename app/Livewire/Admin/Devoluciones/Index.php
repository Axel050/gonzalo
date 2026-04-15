<?php

namespace App\Livewire\Admin\Devoluciones;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Devolucion;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $query = '';

    public $searchType = 'todos';

    public $tab = 'devoluciones';

    public $method = '';

    public $id;

    public $comitente_id_selected = null;

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function setTab($tabName)
    {
        $this->tab = $tabName;
        $this->query = '';
        $this->resetPage();
    }

    public function option($method, $id = null, $comitente_id = null)
    {
        $this->method = $method;
        $this->id = $id;
        $this->comitente_id_selected = $comitente_id;
    }

    #[On(['devolucionCreated', 'devolucionesGenerated'])]
    public function close()
    {
        $this->method = '';
        $this->id = null;
        $this->comitente_id_selected = null;
        $this->resetPage();
    }

    public function anular($id, \App\Services\DevolucionService $devolucionService)
    {
        $devolucionService->anularDevolucion($id);
        $this->method = '';
        $this->dispatch('devolucionUpdated');
    }

    public function render()
    {
        $pendientesCount = Comitente::whereHas('Clotes', function ($q) {
            $q->where('estado', LotesEstados::STANDBY);
        })->count();

        if ($this->tab === 'devoluciones') {
            $devolucionesQuery = Devolucion::with(['motivo', 'lotes.comitente', 'lote.comitente']);

            if ($this->query) {
                switch ($this->searchType) {
                    case 'id':
                        $devolucionesQuery->where('id', 'like', '%'.$this->query.'%');
                        break;
                    case 'comitente':
                        $devolucionesQuery->where(function ($query) {
                            $query->whereHas('lotes.comitente', function ($q) {
                                $q->where('nombre', 'like', '%'.$this->query.'%')
                                    ->orWhere('apellido', 'like', '%'.$this->query.'%')
                                    ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%']);
                            })->orWhereHas('lote.comitente', function ($q) {
                                $q->where('nombre', 'like', '%'.$this->query.'%')
                                    ->orWhere('apellido', 'like', '%'.$this->query.'%')
                                    ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%']);
                            });
                        });
                        break;
                    case 'todos':
                    default:
                        $devolucionesQuery->where(function ($q) {
                            $q->where('id', 'like', '%'.$this->query.'%')
                                ->orWhereHas('lote.comitente', function ($query) {
                                    $query->where('nombre', 'like', '%'.$this->query.'%')
                                        ->orWhere('apellido', 'like', '%'.$this->query.'%')
                                        ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%']);
                                })
                                ->orWhereHas('lotes.comitente', function ($query) {
                                    $query->where('nombre', 'like', '%'.$this->query.'%')
                                        ->orWhere('apellido', 'like', '%'.$this->query.'%')
                                        ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%']);
                                });
                        });
                        break;
                }
            }

            return view('livewire.admin.devoluciones.index', [
                'devoluciones' => $devolucionesQuery->orderBy('id', 'desc')->paginate(15),
                'comitentes_pendientes' => null,
                'pendientesCount' => $pendientesCount,
            ]);
        }

        $query = Comitente::query();

        if ($this->query) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%'.$this->query.'%')
                    ->orWhere('apellido', 'like', '%'.$this->query.'%')
                    ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%'])
                    ->orWhere('id', $this->query);
            });
        }

        $comitentes_pendientes = $query->whereHas('Clotes', function ($q) {
            $q->where('estado', LotesEstados::STANDBY);
        })->with(['Clotes' => function ($q) {
            $q->where('estado', LotesEstados::STANDBY);
        }])->paginate(15);

        return view('livewire.admin.devoluciones.index', [
            'devoluciones' => null,
            'comitentes_pendientes' => $comitentes_pendientes,
            'pendientesCount' => $pendientesCount,
        ]);
    }
}
