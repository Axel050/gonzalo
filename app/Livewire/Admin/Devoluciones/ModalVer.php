<?php

namespace App\Livewire\Admin\Devoluciones;

use App\Models\Devolucion;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class ModalVer extends Component
{
    public $id;
    public $devolucion;

    public function mount($id)
    {
        $this->id = $id;
        $this->devolucion = Devolucion::with([
            'motivo',
            'lote.comitente',
            'lote.ultimoContrato.subasta',
            'lotes.comitente',
            'lotes.ultimoContrato.subasta'
        ])->find($id);
    }

    public function close()
    {
        $this->dispatch('devolucionesGenerated');
    }

    public function downloadPdf()
    {
        if (!$this->devolucion) {
            return;
        }

        $logoPath = public_path('img/mail.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        $pdf = Pdf::loadView('livewire.admin.devoluciones.pdf', [
            'devolucion' => $this->devolucion,
            'logo' => $logoBase64,
        ])->setPaper('a4');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'devolucion-' . $this->devolucion->id . '.pdf');
    }

    public function render()
    {
        return view('livewire.admin.devoluciones.modal-ver');
    }
}
