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

    public $searchType = 'todos';

    public $method = '';

    public $id;

    public $tab = 'liquidaciones';

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

    public function render()
    {
        $pendientesCount = Comitente::whereHas('Clotes', function ($q) {
            $q->where('estado', LotesEstados::FACTURADO);
        })->count();

        if ($this->tab === 'liquidaciones') {
            $liquidaciones = Liquidacion::with('comitente');

            if ($this->query) {
                switch ($this->searchType) {
                    case 'id':
                        $liquidaciones->where('id', 'like', '%'.$this->query.'%');
                        break;
                    case 'comitente':
                        $liquidaciones->whereHas('comitente', function ($q) {
                            $q->where('nombre', 'like', '%'.$this->query.'%')
                                ->orWhere('apellido', 'like', '%'.$this->query.'%');
                        });
                        break;
                    case 'todos':
                        $liquidaciones->where(function ($q) {
                            $q->where('id', 'like', '%'.$this->query.'%')
                                ->orWhereHas('comitente', function ($query) {
                                    $query->where('nombre', 'like', '%'.$this->query.'%')
                                        ->orWhere('apellido', 'like', '%'.$this->query.'%');
                                });
                        });
                        break;
                }
            }

            $liquidaciones = $liquidaciones->orderBy('id', 'desc')->paginate(15);

            return view('livewire.admin.liquidaciones.index', [
                'liquidaciones' => $liquidaciones,
                'comitentes_pendientes' => null,
                'pendientesCount' => $pendientesCount,
            ]);
        } else {
            $query = Comitente::query();

            if ($this->query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%'.$this->query.'%')
                        ->orWhere('apellido', 'like', '%'.$this->query.'%')
                        ->orWhere('alias', 'like', '%'.$this->query.'%');
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
