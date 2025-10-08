<?php

namespace App\Livewire\Admin\Ordenes;

use App\Enums\LotesEstados;
use App\Mail\ContratoEmail;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Garantia;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Orden;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Modal extends Component

{
  public $new;

  public $modal_foto = false;
  public $search;
  public $lotes = [];
  public $monedas = [];
  public string $si;

  public $te = 1;

  public $id;
  public $foto1;

  public $moneda_id = 1; //peso
  public $contrato;
  public $lote_id = false;
  public $titulo, $descripcion, $precio_base;
  public $autorizados = [];

  public $tempLotes = [];
  public $method;




  public $payment;
  public $fecha;
  public $estado;
  public $adquirente;
  public $subasta;
  public $ordenSeleccionada;
  public $subtotal = 0;
  public $deposito = 0;
  public $total = 0;

  public function closeModal()
  {
    // Dispara el evento para cerrar el modal en Alpine.js
    $this->dispatch('close-modal');
    // Limpia la propiedad después de la animación
    $this->modal_foto = null;
  }



  public function mount()
  {
    $this->ordenSeleccionada = Orden::with('lotes.lote')->find($this->id);

    if (!$this->ordenSeleccionada) {
      $this->subtotal = $this->deposito = $this->total = 0;
      return;
    }

    $this->subasta = $this->ordenSeleccionada->subasta->titulo;
    $this->adquirente = $this->ordenSeleccionada->adquirente->nombre . " " . $this->ordenSeleccionada->adquirente->apellido;
    $this->estado = $this->ordenSeleccionada->estado;
    $this->payment = $this->ordenSeleccionada->payment_id;
    $this->fecha = $this->ordenSeleccionada->fecha_pago;
    // Calcular subtotal
    $this->subtotal = $this->ordenSeleccionada->lotes->sum('precio_final');

    // Buscar garantía aplicada (depósito)
    $garantia = Garantia::where('adquirente_id', $this->ordenSeleccionada->adquirente_id)
      ->where('subasta_id', $this->ordenSeleccionada->subasta_id)
      ->where('estado', 'pagado')
      ->first();

    $this->deposito = $garantia?->monto ?? 0;
    info($garantia);
    info($this->deposito);
    // Calcular total final
    $this->total = max(0, $this->subtotal - $this->deposito);
    $this->monedas = Moneda::all()->keyBy('id');
  }






  public function render()
  {
    return view('livewire.admin.ordenes.modal');
  }
}
