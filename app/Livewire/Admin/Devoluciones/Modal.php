<?php

namespace App\Livewire\Admin\Devoluciones;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Lote;
use App\Models\MotivoDevolucion;
use App\Services\DevolucionService;
use Livewire\Component;

class Modal extends Component
{
    public $method;
    public $comitente_id;
    public $comitentes = [];
    public $motivos = [];
    public $motivo_id;
    public $lotes_standby = [];
    public $lotes_seleccionados = [];
    public $descripcion = '';
    public $fecha;

    public function mount($method, $comitente_id = null)
    {
        $this->method = $method;
        $this->comitentes = Comitente::orderBy('nombre')->get();
        $this->motivos = MotivoDevolucion::orderBy('nombre')->get();
        $this->fecha = now()->toDateString();

        if ($comitente_id) {
            $this->comitente_id = $comitente_id;
            $this->updatedComitenteId($comitente_id);
        }
    }

    public function updatedComitenteId($val)
    {
        $this->lotes_standby = [];
        $this->lotes_seleccionados = [];

        if (!$val) {
            return;
        }

        $this->lotes_standby = Lote::with(['ultimoConLote', 'ultimoContrato.subasta'])
            ->where('comitente_id', $val)
            ->where('estado', LotesEstados::STANDBY)
            ->orderBy('id', 'desc')
            ->get();
    }

    public function save(DevolucionService $devolucionService)
    {
        $this->validate([
            'comitente_id' => 'required|exists:comitentes,id',
            'motivo_id' => 'required|exists:motivo_devolucions,id',
            'fecha' => 'required|date',
            'lotes_seleccionados' => 'required|array|min:1',
        ], [
            'lotes_seleccionados.required' => 'Seleccione al menos un lote a devolver.',
            'lotes_seleccionados.min' => 'Seleccione al menos un lote a devolver.',
        ]);

        $devolucionService->crearDevoluciones(
            (int) $this->motivo_id,
            array_map('intval', $this->lotes_seleccionados),
            $this->descripcion,
            $this->fecha
        );

        $this->dispatch('devolucionCreated');
        session()->flash('success', 'Devolución generada correctamente.');
    }

    public function close()
    {
        $this->dispatch('devolucionCreated');
    }

    public function render()
    {
        return view('livewire.admin.devoluciones.modal');
    }
}
