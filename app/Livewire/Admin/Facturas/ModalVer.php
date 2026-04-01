<?php

namespace App\Livewire\Admin\Facturas;

use Livewire\Component;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;

class ModalVer extends Component
{
  public $id;
  public $factura;

  /**
   * Se ejecuta al abrir el modal
   */
  public function mount($id)
  {
    $this->id = $id;
    $this->loadFactura();
  }

  /**
   * Cargar factura con relaciones
   */
  public function loadFactura()
  {
    $this->factura = Factura::with([
      'items.lote',
      'adquirente',
      'ordenes' // 👈 importante si usás many-to-many
    ])->find($this->id);

    if (!$this->factura) {
      $this->dispatch('error', ['mensaje' => 'Factura no encontrada']);
      $this->close();
    }
  }

  /**
   * Cerrar modal
   */
  public function close()
  {
    $this->dispatch('facturasGenerated'); // mismo evento que usás
  }

  /**
   * Descargar PDF
   */
  public function downloadFactura()
  {
    if (!$this->factura) return;

    $logoPath = public_path('img/mail.png');

    $logoBase64 = file_exists($logoPath)
      ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
      : null;

    $pdf = Pdf::loadView('admin.facturas.pdf', [
      'factura' => $this->factura,
      'items' => $this->factura->items,
      'adquirente' => $this->factura->adquirente,
      'ordenes' => $this->factura->ordenes,
      'logo' => $logoBase64
    ])->setPaper('a4');

    return response()->streamDownload(function () use ($pdf) {
      echo $pdf->output();
    }, 'factura-' . $this->factura->id . '.pdf');
  }

  public function render()
  {
    return view('livewire.admin.facturas.modal-ver');
  }
}
