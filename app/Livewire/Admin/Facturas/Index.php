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

    public $dateFrom;

    public $dateTo;    public $searchType = 'todos';

    public $method = '';

    public $id;

    public $tab = 'facturas';

    public $adquirente_id_selected = null;

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

    public function anular($id, \App\Services\FacturaService $facturaService)
    {
        $facturaService->anularFactura($id);
        $this->method = '';
        $this->dispatch('facturaUpdated');
    }

    public function render()
    {
        $pendientesCount = Adquirente::whereHas('ordenes', function ($q) {
            $q->where('estado', 'pagada')->whereNull('facturas_generadas_at');
        })->count();

        if ($this->tab === 'facturas') {
            $facturasQuery = Factura::query();

            if ($this->query) {
                switch ($this->searchType) {
                    case 'id':
                        $facturasQuery->where('id', 'like', '%'.$this->query.'%');
                        break;
                    case 'fecha':
                        $facturasQuery->where('fecha', 'like', '%'.$this->query.'%');
                        break;
                    case 'adquirente':
                        $facturasQuery->whereHas('adquirente', function ($q) {
                            $q->where('nombre', 'like', '%'.$this->query.'%')
                                ->orWhere('apellido', 'like', '%'.$this->query.'%')
                                ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%']);
                        });
                        break;
                    case 'orden':
                        $facturasQuery->whereHas('ordenes', function ($q) {
                            $q->where('ordens.id', 'like', '%'.$this->query.'%');
                        });
                        break;
                    case 'cae':
                        $facturasQuery->where('cae', 'like', '%'.$this->query.'%');
                        break;
                    case 'todos':
                        $facturasQuery->where(function ($q) {
                            $q->where('id', 'like', '%'.$this->query.'%')
                                ->orWhereHas('ordenes', function ($q) {
                                    $q->where('ordens.id', 'like', '%'.$this->query.'%');
                                })
                                ->orWhere('nombre', 'like', '%'.$this->query.'%')
                                ->orWhere('apellido', 'like', '%'.$this->query.'%')
                                ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%'])
                                ->orWhere('cae', 'like', '%'.$this->query.'%')
                                ->orWhere('fecha', 'like', '%'.$this->query.'%');
                        });
                        break;
                }
            }

            if ($this->dateFrom) {
                $facturasQuery->whereDate('fecha', '>=', $this->dateFrom);
            }

            if ($this->dateTo) {
                $facturasQuery->whereDate('fecha', '<=', $this->dateTo);
            }

            $global_martillo = (clone $facturasQuery)->where('estado', '!=', 'anulada')->where('tipo_concepto', 'martillo')->sum('monto_total');
            $global_servicios = (clone $facturasQuery)->where('estado', '!=', 'anulada')->where('tipo_concepto', '!=', 'martillo')->sum('monto_total');
            $global_total = (clone $facturasQuery)->where('estado', '!=', 'anulada')->sum('monto_total');

            $facturas = $facturasQuery->orderBy('id', 'desc')->paginate(15);

            return view('livewire.admin.facturas.index', [
                'facturas' => $facturas,
                'adquirentes_pendientes' => null,
                'pendientesCount' => $pendientesCount,
                'global_total' => $global_total,
                'global_martillo' => $global_martillo,
                'global_servicios' => $global_servicios,
            ]);
        } else {
            $query = Adquirente::query();

            if ($this->query) {
                $query->where(function ($q) {
                    $q->where('nombre', 'like', '%'.$this->query.'%')
                        ->orWhere('apellido', 'like', '%'.$this->query.'%')
                        ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ['%'.$this->query.'%']);
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
