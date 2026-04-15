<?php

namespace App\Livewire\Admin\Facturas;

use App\Models\Adquirente;
use App\Models\Orden;
use App\Services\FacturaService;
use Livewire\Component;

class Modal extends Component
{
    public $query = '';

    public $ordenes = [];

    public $ordenesSeleccionadas = [];

    public $selectAll = false;

    public $step = 1;

    public function mount($id = null, $method = null, $adquirente_id = null)
    {
        if ($adquirente_id) {
            $adq = Adquirente::find($adquirente_id);
            if ($adq) {
                $this->query = $adq->apellido;
                $this->updatedQuery();
                // Auto select all if we pre-filled
                if (count($this->ordenes) > 0) {
                    $this->selectAll = true;
                    $this->updatedSelectAll(true);
                }
            }
        }
    }

    /*
      |--------------------------------------------------------------------------
      | BUSQUEDA
      |--------------------------------------------------------------------------
      */
    public function updatedQuery()
    {
        if (strlen($this->query) > 1) {
            $this->ordenes = Orden::with('adquirente')
                ->where('estado', '=', 'pagada')
                ->whereNull('facturas_generadas_at')
                ->where(function ($q) {
                    $q->where('id', 'like', "%{$this->query}%")
                        ->orWhereHas('adquirente', function ($q2) {
                            $q2->where('nombre', 'like', "%{$this->query}%")
                                ->orWhere('apellido', 'like', "%{$this->query}%");
                        });
                })
                ->take(10)
                ->get();
        } else {
            $this->ordenes = [];
        }
    }

    /*
      |--------------------------------------------------------------------------
      | SELECT ALL
      |--------------------------------------------------------------------------
      */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->ordenesSeleccionadas = collect($this->ordenes)->pluck('id')->toArray();
        } else {
            $this->ordenesSeleccionadas = [];
        }
    }

    public function updatedOrdenesSeleccionadas()
    {
        $this->selectAll = count($this->ordenesSeleccionadas) === count($this->ordenes);
    }

    /*
      |--------------------------------------------------------------------------
      | RELACION MODELOS
      |--------------------------------------------------------------------------
      */
    public function getOrdenesSeleccionadasModelProperty()
    {
        return Orden::with('adquirente', 'lotes')
            ->whereIn('id', $this->ordenesSeleccionadas)
            ->get();
    }

    /*
      |--------------------------------------------------------------------------
      | PASOS
      |--------------------------------------------------------------------------
      */
    public function nextStep()
    {
        if (empty($this->ordenesSeleccionadas)) {
            $this->dispatch('error', ['mensaje' => 'Seleccioná al menos una orden']);

            return;
        }

        $this->step = 2;
    }

    public function prevStep()
    {
        $this->step = 1;
    }

    /*
      |--------------------------------------------------------------------------
      | RESUMEN
      |--------------------------------------------------------------------------
      */
    public function getResumenProperty()
    {
        return $this->ordenesSeleccionadasModel->map(function ($orden) {

            $total = $orden->lotes->sum('precio_final');
            $comision = $total * ($orden->porcentaje_comision ?? 20) / 100;
            $envio = $orden->monto_envio ?? 0;

            return [
                'orden_id' => $orden->id,
                'total' => $total,
                'comision' => $comision,
                'envio' => $envio,
                'final' => $total + $comision + $envio,
            ];
        });
    }

    /*
      |--------------------------------------------------------------------------
      | GENERAR
      |--------------------------------------------------------------------------
      */
    public function generarFacturas(FacturaService $service)
    {
        try {

            $result = $service->generarFacturasAgrupadas($this->ordenesSeleccionadas);

            $msg = 'Facturas generadas: ';

            if ($result['martillo']) {
                $msg .= "Martillo #{$result['martillo']->id} ";
            }

            if ($result['servicios']) {
                $msg .= "Servicios #{$result['servicios']->id}";
            }

            $this->dispatch('success', ['mensaje' => $msg]);

            $this->dispatch('facturaCreated');

            $this->reset(['ordenesSeleccionadas', 'selectAll', 'query', 'ordenes', 'step']);
        } catch (\Exception $e) {
            $this->dispatch('error', ['mensaje' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.facturas.modal');
    }
}
