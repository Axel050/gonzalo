<?php

namespace App\Livewire\Admin\Ordenes;

use App\Enums\LotesEstados;
use App\Enums\MotivosCancelaciones;
use App\Enums\OrdenesEstados;
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

  public $estados = [];
  public $motivos = [];
  public $motivo = [];
  public $otroMotivo;

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
  public $envio;


  public $envido;




  public $payment;
  public $fecha;
  public $estado;
  public $adquirente;
  public $subasta;
  public $ordenSeleccionada;
  public $subtotal = 0;
  public $deposito = 0;
  public $total = 0;


  public $lotesEliminadosTemporales = []; // Nuevo: IDs de lotes quitados temporalmente
  public $lotesOriginales = []; // Nuevo: Para comparar al guardar

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

    $this->estados = array_map(function ($estado) {
      return [
        'value' => $estado,
        'label' => OrdenesEstados::getLabel($estado),
      ];
    }, OrdenesEstados::all());

    $this->motivos = array_map(function ($estado) {
      return [
        'value' => $estado,
        'label' => MotivosCancelaciones::getLabel($estado),
      ];
    }, MotivosCancelaciones::all());

    if (!$this->ordenSeleccionada) {
      $this->subtotal = $this->deposito = $this->total = 0;
      return;
    }

    $this->subasta = $this->ordenSeleccionada->subasta->titulo;
    $this->adquirente = $this->ordenSeleccionada->adquirente->nombre . " " . $this->ordenSeleccionada->adquirente->apellido;
    $this->estado = $this->ordenSeleccionada->estado;
    $this->payment = $this->ordenSeleccionada->payment_id;
    $this->fecha = $this->ordenSeleccionada->fecha_pago;
    $this->envio = $this->ordenSeleccionada->subasta?->envio;
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

    if ($this->envio) {
      $this->total += $this->envio;
    }

    $this->monedas = Moneda::all()->keyBy('id');


    $this->lotesOriginales = $this->ordenSeleccionada->lotes->pluck('lote_id')->toArray();

    // Inicializa tempLotes con la lista actual (si lo usas para algo más)
    $this->tempLotes = $this->ordenSeleccionada->lotes->toArray();
  }



  public function updatedEnvio()
  {
    // Validar que sea un número entero mayor o igual a 0
    if (!is_numeric($this->envio) || $this->envio < 0 || floor($this->envio) != $this->envio) {
      $this->envio = 0; // Resetear a 0 si no es válido
      $this->total = max(0, $this->subtotal - $this->deposito);
      return;
    }

    // Convertir a entero por si acaso
    $this->envio = (int)$this->envio;

    if ($this->envio > 0) {
      $this->total = max(0, $this->subtotal - $this->deposito);


      $this->total += $this->envio;
    }
  }



  public function quitar($loteId)
  {
    // Agrega a eliminados temporales (solo si no está ya)
    if (!in_array($loteId, $this->lotesEliminadosTemporales)) {
      $this->lotesEliminadosTemporales[] = $loteId;
    }

    // Recarga la orden filtrando lotes por lote_id NO en eliminados
    $this->ordenSeleccionada = Orden::with([
      'lotes' => function ($query) {
        $query->whereNotIn('lote_id', $this->lotesEliminadosTemporales);
      },
      'lotes.lote'  // Sigue cargando la relación anidada para los filtrados
    ])->find($this->id);

    // Recalcula subtotales (igual que antes)
    $this->subtotal = $this->ordenSeleccionada->lotes->sum('precio_final');
    $this->total = max(0, $this->subtotal - $this->deposito);
    if ($this->envio) {
      $this->total += $this->envio;
    }

    // Opcional: Dispatch evento para UI
    $this->dispatch('lote-quitado', ['mensaje' => 'Lote quitado temporalmente. Guarda para confirmar.']);
  }



  public function update()
  {
    // Ejemplo: Eliminar pivots para lotes removidos
    foreach ($this->lotesEliminadosTemporales as $loteId) {
      $this->ordenSeleccionada->lotes()->where('lote_id', $loteId)->delete();

      $lote = Lote::find($loteId);
      if ($lote) {
        $lote->update(['estado' => LotesEstados::STANDBY]); // O el valor exacto, e.g., 'standby' si no es enum
      }
    }


    $this->ordenSeleccionada->update([
      'estado' => $this->estado,
      'motivo' => $this->motivo ?? null, // Si es cancelada
      'otro' => $this->otroMotivo ?? null, // Si motivo == 'otro'
      'envio' => $this->envio ?? null, // Si pagada
      'fecha_pago' => $this->fecha ?? null,
      'payment_id' => $this->payment ?? null,
      // Agrega otros campos si es necesario, e.g., payment_id si editable
    ]);


    // ... resto de lógica de save (actualizar estado, etc.) ...
    $this->lotesEliminadosTemporales = [];
    $this->dispatch("ordenUpdated");
    // Limpia temporales
  }




  public function render()
  {
    return view('livewire.admin.ordenes.modal');
  }
}
