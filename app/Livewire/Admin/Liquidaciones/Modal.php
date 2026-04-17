<?php

namespace App\Livewire\Admin\Liquidaciones;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Liquidacion;
use App\Models\Lote;
use App\Services\LiquidacionService;
use Livewire\Component;

class Modal extends Component
{
    public $method;

    public $liquidacion_id;

    // Campos del formulario add
    public $comitente_id;

    public $comitentes = [];

    public $lotes_vendidos = [];

    public $lotes_seleccionados = [];

    public $comision_porcentaje = 0;

    public $gastos_extra = [];

    // Totales en vivo
    public $subtotal_lotes = 0;

    public $subtotal_comisiones = 0;

    public $subtotal_gastos = 0;

    public $monto_total = 0;

    public $observaciones = '';

    public function mount($method, $id = null, $comitente_id = null)
    {
        $this->method = $method;
        $this->liquidacion_id = $id;

        if ($this->method === 'add') {
            $this->comitentes = Comitente::orderBy('nombre')->get();
            $this->agregarGasto();

            if ($comitente_id) {
                $this->comitente_id = $comitente_id;
                $this->updatedComitenteId($comitente_id);
            }
        }
    }

    public function updatedComitenteId($val)
    {
        $this->lotes_vendidos = [];
        $this->lotes_seleccionados = [];
        $this->comision_porcentaje = 0;

        if ($val) {
            $comitente = Comitente::find($val);
            if ($comitente) {
                // Pre-fill comisión
                $this->comision_porcentaje = (int) $comitente->comision ?? 0;

                // Buscar lotes FACTURADO de este comitente (y que no esten ya en una liquidacion)
                $this->lotes_vendidos = Lote::where('comitente_id', $val)
                    ->where('estado', LotesEstados::FACTURADO)
                    ->get();

                // Seleccionar todos por defecto
                $this->lotes_seleccionados = $this->lotes_vendidos->pluck('id')->toArray();
            }
        }
        $this->calcularTotales();
    }

    public function updatedLotesSeleccionados()
    {
        $this->calcularTotales();
    }

    public function updatedComisionPorcentaje()
    {
        $this->calcularTotales();
    }

    public function updatedGastosExtra()
    {
        $this->calcularTotales();
    }

    public function agregarGasto()
    {
        $this->gastos_extra[] = ['concepto' => '', 'monto' => 0];
        $this->calcularTotales();
    }

    public function quitarGasto($index)
    {
        unset($this->gastos_extra[$index]);
        $this->gastos_extra = array_values($this->gastos_extra); // Reindex
        $this->calcularTotales();
    }

    public function calcularTotales()
    {
        $this->subtotal_lotes = 0;
        $this->subtotal_comisiones = 0;
        $this->subtotal_gastos = 0;

        // Sumar lotes
        foreach ($this->lotes_vendidos as $lote) {
            if (in_array($lote->id, $this->lotes_seleccionados)) {
                $this->subtotal_lotes += $lote->precio_final;
            }
        }

        // Comision

        $comision = floatval($this->comision_porcentaje);

        if ($comision > 0) {
            $this->subtotal_comisiones = round(($this->subtotal_lotes * $comision) / 100, 0);
        }

        // Gastos
        foreach ($this->gastos_extra as $gasto) {
            $monto = floatval($gasto['monto']);
            if ($monto > 0) {
                $this->subtotal_gastos += $monto;
            }
        }

        $this->monto_total = $this->subtotal_lotes - $this->subtotal_comisiones - $this->subtotal_gastos;
    }

    public function save(LiquidacionService $servicio)
    {
        $this->validate([
            'comitente_id' => 'required|exists:comitentes,id',
            'lotes_seleccionados' => 'array',
        ]);

        $comitente = Comitente::find($this->comitente_id);

        $items = [];

        // Lotes seleccionados
        foreach ($this->lotes_vendidos as $lote) {
            if (in_array($lote->id, $this->lotes_seleccionados)) {
                $items[] = [
                    'tipo' => 'ingreso',
                    'concepto' => "Venta lote {$lote->titulo} - #{$lote->id}",
                    'monto' => $lote->precio_final,
                    'lote_id' => $lote->id,
                    'subasta_id' => $lote->subastas()->latest()->first()->id ?? null,
                ];
            }
        }

        if ($this->subtotal_comisiones > 0) {
            $items[] = [
                'tipo' => 'egreso_comision',
                'concepto' => "{$this->comision_porcentaje}%",
                'monto' => $this->subtotal_comisiones,
                'lote_id' => null,
                'subasta_id' => null,
            ];
        }

        foreach ($this->gastos_extra as $gasto) {
            if (floatval($gasto['monto']) > 0 && ! empty($gasto['concepto'])) {
                $items[] = [
                    'tipo' => 'egreso_gasto',
                    'concepto' => $gasto['concepto'],
                    'monto' => floatval($gasto['monto']),
                    'lote_id' => null,
                    'subasta_id' => null,
                ];
            }
        }

        $servicio->crearLiquidacion($comitente, $items, $this->comision_porcentaje, $this->observaciones);

        $this->dispatch('liquidacionCreated');
        session()->flash('success', 'Liquidación creada exitosamente.');
    }

    public function close()
    {
        $this->dispatch('liquidacionCreated');
    }

    public function render()
    {
        return view('livewire.admin.liquidaciones.modal');
    }
}
