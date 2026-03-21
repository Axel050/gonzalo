<?php

namespace App\Livewire\Admin\Facturas;

use App\Models\Orden;
use App\Models\Factura;
use App\Services\FacturaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class Modal extends Component
{
  public $id;
  public $method;
  public $searchType = 'orden';
  public $query;
  public $ordenes = [];
  public $ordenSeleccionada;
  public $factura;

  public function mount()
  {
    if ($this->method == 'view' && $this->id) {
      $this->factura = Factura::with('items.lote', 'adquirente')->find($this->id);
    }
  }

  public function updatedQuery()
  {
    if (strlen($this->query) > 1) {
      $this->ordenes = Orden::with('adquirente')
        ->where('id', 'like', '%' . $this->query . '%')
        ->orWhereHas('adquirente', function ($q) {
          $q->where('nombre', 'like', '%' . $this->query . '%')
            ->orWhere('apellido', 'like', '%' . $this->query . '%');
        })
        ->take(10)
        ->get();
    } else {
      $this->ordenes = [];
    }
  }

  public function seleccionarOrden($ordenId)
  {
    $this->ordenSeleccionada = Orden::with('lotes.lote', 'adquirente', 'subasta')->find($ordenId);
    $this->ordenes = [];
    $this->query = '';
  }

  public function generarFacturas(FacturaService $service)
  {
    if (!$this->ordenSeleccionada) return;

    try {
      $facturas = $service->generarFacturasDesdeOrden($this->ordenSeleccionada);
      info("antes dispartch");
      $this->dispatch('success', ['mensaje' => count($facturas) . ' facturas generadas correctamente.']);
      $this->dispatch('facturasGenerated');
    } catch (\Exception $e) {
      $this->dispatch('error', ['mensaje' => 'Error: ' . $e->getMessage()]);
    }
  }

  public function closeModal()
  {
    $this->dispatch('facturaCreated'); // Para cerrar en el index
  }





  public function downloadFactura($facturaId)
  {
    $factura = \App\Models\Factura::with([
      'items.lote',
      'adquirente'
    ])->find($facturaId);

    if (!$factura) {
      return;
    }

    $logoPath = public_path('img/mail.png'); // si está en /public/img/mail.png

    if (file_exists($logoPath)) {
      $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    } else {
      $logoBase64 = null;
    }





    $pdf = Pdf::loadView('admin.facturas.pdf', [
      'factura' => $factura,
      'items' => $factura->items,
      'adquirente' => $factura->adquirente,
      'logo' => $logoBase64

    ])->setPaper('a4');

    return response()->streamDownload(function () use ($pdf) {
      echo $pdf->output();
    }, 'factura-' . $factura->id . '.pdf');
  }



  public function render()
  {
    return view('livewire.admin.facturas.modal');
  }
}
