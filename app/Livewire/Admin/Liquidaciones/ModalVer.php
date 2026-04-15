<?php

namespace App\Livewire\Admin\Liquidaciones;

use App\Models\Liquidacion;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class ModalVer extends Component
{
    public $id;
    public $liquidacion;

    public function mount($id)
    {
        $this->id = $id;
        $this->loadLiquidacion();
    }

    public function loadLiquidacion()
    {
        $this->liquidacion = Liquidacion::with(['comitente', 'items.lote', 'items.subasta'])->find($this->id);

        if (!$this->liquidacion) {
            $this->dispatch('error', ['mensaje' => 'Liquidación no encontrada']);
            $this->close();
        }
    }

    public function close()
    {
        $this->dispatch('liquidacionesGenerated'); // Uses the same event as the modal
    }

    public function downloadPdf()
    {
        if (!$this->liquidacion) return;

        $logoPath = public_path('img/mail.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $pdf = Pdf::loadView('livewire.admin.liquidaciones.pdf', [
            'liquidacion' => $this->liquidacion,
            'items' => $this->liquidacion->items,
            'comitente' => $this->liquidacion->comitente,
            'logo' => $logoBase64
        ])->setPaper('a4');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'liquidacion-' . $this->liquidacion->numero . '.pdf');
    }

    public function render()
    {
        return view('livewire.admin.liquidaciones.modal-ver');
    }
}
