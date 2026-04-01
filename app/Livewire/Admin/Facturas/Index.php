<?php

namespace App\Livewire\Admin\Facturas;

use App\Models\Adquirente;
use App\Models\Factura;
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

    public $tab = 'facturas';

    public $adquirente_id_selected = null;

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

    public function option($method, $id = false, $adquirente_id = null)
    {
        $this->method = $method;
        $this->id = $id;
        $this->adquirente_id_selected = $adquirente_id;
    }

    #[On(['facturaCreated', 'facturasGenerated'])]
    public function close()
    {
        $this->method = '';
        $this->adquirente_id_selected = null;
        $this->resetPage();
    }

    public function render()
    {
        $pendientesCount = Adquirente::whereHas('ordenes', function ($q) {
            $q->where('estado', 'pagada')->whereNull('facturas_generadas_at');
        })->count();

        if ($this->tab === 'facturas') {
            $facturas = Factura::query();

            if ($this->query) {
                switch ($this->searchType) {
                    case 'id':
                        $facturas->where('id', 'like', '%'.$this->query.'%');
                        break;
                    case 'fecha':
                        $facturas->where('fecha', 'like', '%'.$this->query.'%');
                        break;
                    case 'adquirente':
                        $facturas->whereHas('adquirente', function ($q) {
                            $q->where('nombre', 'like', '%'.$this->query.'%')
                                ->orWhere('apellido', 'like', '%'.$this->query.'%');
                        });
                        break;
                    case 'orden':
                        $facturas->whereHas('ordenes', function ($q) {
                            $q->where('ordens.id', 'like', '%'.$this->query.'%');
                        });
                        break;
                    case 'cae':
                        $facturas->where('cae', 'like', '%'.$this->query.'%');
                        break;
                    case 'todos':
                        $facturas->where(function ($q) {
                            $q->where('id', 'like', '%'.$this->query.'%')
                                ->orWhereHas('ordenes', function ($q) {
                                    $q->where('ordens.id', 'like', '%'.$this->query.'%');
                                })
                                ->orWhere('nombre', 'like', '%'.$this->query.'%')
                                ->orWhere('apellido', 'like', '%'.$this->query.'%')
                                ->orWhere('cae', 'like', '%'.$this->query.'%')
                                ->orWhere('fecha', 'like', '%'.$this->query.'%');
                        });
                        break;
                }
            }

            $facturas = $facturas->orderBy('id', 'desc')->paginate(15);

            return view('livewire.admin.facturas.index', [
                'facturas' => $facturas,
                'adquirentes_pendientes' => null,
                'pendientesCount' => $pendientesCount,
            ]);
        } else {
            $query = Adquirente::query();

            if ($this->query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%'.$this->query.'%')
                        ->orWhere('apellido', 'like', '%'.$this->query.'%');
                });
            }

            $adquirentes_pendientes = $query->whereHas('ordenes', function ($q) {
                $q->where('estado', 'pagada')->whereNull('facturas_generadas_at');
            })->with(['ordenes' => function ($q) {
                $q->where('estado', 'pagada')->whereNull('facturas_generadas_at');
            }])->paginate(15);

            return view('livewire.admin.facturas.index', [
                'facturas' => null,
                'adquirentes_pendientes' => $adquirentes_pendientes,
                'pendientesCount' => $pendientesCount,
            ]);
        }
    }
}
