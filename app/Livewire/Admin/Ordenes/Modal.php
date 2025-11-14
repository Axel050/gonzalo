<?php

namespace App\Livewire\Admin\Ordenes;

use App\Enums\LotesEstados;
use App\Enums\MotivosCancelaciones;
use App\Enums\OrdenesEstados;
use App\Mail\ContratoEmail;
use App\Models\Adquirente;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Garantia;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Orden;
use App\Models\Subasta;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Modal extends Component
{
  public $title;
  public $bg;
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
  public $foto1;
  public $moneda_id = 1;
  public $contrato;
  public $lote_id = false;
  public $titulo, $descripcion, $precio_base;
  public $autorizados = [];
  public $tempLotes = [];

  public $id;
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
  public $lotesEliminadosTemporales = [];
  public $lotesOriginales = [];

  // Nuevas propiedades para crear órdenes
  public $adquirente_id;
  public $subasta_id;
  public $adquirentes = [];
  public $subastas = [];

  public function closeModal()
  {
    $this->dispatch('close-modal');
    $this->modal_foto = null;
  }

  public function mount()
  {
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

    $this->adquirentes = Adquirente::orderBy("nombre")->get();

    if ($this->method == "update") {
      $this->bg = "background-color: rgb(234 88 12)";
      $this->title = "Editar";
    } else {
      $this->bg =  "background-color: rgb(31, 83, 44)";
      $this->title = "Ver";
    }

    // Si es creación nueva
    if ($this->method == 'add') {
      $this->title = "Crear";
      $this->initializeNewOrder();
    }

    // Si es edición
    else if ($this->method == 'update' && $this->id || $this->method == "view") {
      $this->initializeExistingOrder();
    }

    $this->monedas = Moneda::all()->keyBy('id');
  }

  protected function initializeNewOrder()
  {
    $this->ordenSeleccionada = new Orden();
    $this->estado = 'pendiente';
    $this->tempLotes = [];
    info("2222222222222");
    // Cargar listas para selects
    // $this->adquirentes = User::where('rol', 'adquirente')
    //   ->orWhere('rol', 'usuario')
    //   ->get();

    $this->subastas = Subasta::whereIn('estado', ['inactiva', 'finalizada'])->get();

    // Valores por defecto
    $this->subtotal = 0;
    $this->deposito = 0;
    $this->total = 0;
    $this->envio = 0;
  }

  protected function initializeExistingOrder()
  {
    $this->ordenSeleccionada = Orden::with('lotes.lote.ultimoConLote.moneda')->find($this->id);

    if (!$this->ordenSeleccionada) {
      $this->subtotal = $this->deposito = $this->total = 0;
      return;
    }

    $this->subasta = $this->ordenSeleccionada->subasta->titulo;
    $this->adquirente = $this->ordenSeleccionada->adquirente->nombre . " " . $this->ordenSeleccionada->adquirente->apellido;
    $this->estado = $this->ordenSeleccionada->estado;
    $this->payment = $this->ordenSeleccionada->payment_id;
    $this->fecha = $this->ordenSeleccionada->fecha_pago;
    $this->envio = $this->ordenSeleccionada->monto_envio;

    // Calcular subtotal
    $this->subtotal = $this->ordenSeleccionada->lotes->sum('precio_final');

    // Buscar garantía aplicada (depósito)
    $garantia = Garantia::where('adquirente_id', $this->ordenSeleccionada->adquirente_id)
      ->where('subasta_id', $this->ordenSeleccionada->subasta_id)
      ->where('estado', 'pagado')
      ->first();

    // $this->deposito = $garantia?->monto ?? 0;
    $this->deposito = $this->ordenSeleccionada->descuento;

    // Calcular total final
    $this->total = max(0, $this->subtotal - $this->deposito);
    if ($this->envio) {
      $this->total += $this->envio;
    }

    $this->lotesOriginales = $this->ordenSeleccionada->lotes->pluck('lote_id')->toArray();
    $this->tempLotes = $this->ordenSeleccionada->lotes->map(function ($ordenLote) {
      $lote = $ordenLote->lote;
      $moneda = $lote->ultimoConLote->moneda ?? null;

      return [
        'lote' => $lote->toArray(),
        'precio_final' => $ordenLote->precio_final,
        'moneda_id' => $ordenLote->moneda_id,
        'moneda_signo' => $moneda->signo ?? '$',
        'moneda_titulo' => $moneda->titulo ?? 'Pesos'
      ];
    })->toArray();
  }

  public function updatedSearch($value)
  {


    if (strlen($value) > 1) {
      $query = Lote::where('titulo', 'like', '%' . $value . '%');

      // En creación nueva, solo mostrar lotes disponibles
      if ($this->method == 'add') {
        // $query->where('estado', LotesEstados::DISPONIBLE);

        $query = Lote::where('titulo', 'like', '%' . $value . '%')
          ->whereHas('ultimoContrato', function ($q) {
            $q->where('subasta_id', $this->subasta_id);
          })
          ->byEstado(LotesEstados::DISPONIBLE);
      }
      // En edición, mostrar también los lotes que ya están en la orden


      $this->lotes = $query->take(10)->get();
      $this->si = true;
    } else {
      $this->si = false;
      $this->lotes = [];
    }
  }

  public function loteSelected($loteId)
  {
    // $lote = Lote::with('moneda')->find($loteId);
    $lote = Lote::with('ultimoConLote.moneda')->find($loteId);

    if (!$lote) {
      return;
    }

    // Verificar si el lote ya está en la lista temporal
    $existe = collect($this->tempLotes)->contains('lote.id', $loteId);

    if (!$existe) {
      $monedaId = $lote->ultimoConLote->moneda_id ?? 1; // Default a 1 si no tiene
      $precioFinal = $lote->getPrecioFinalAttribute(); // O el precio que corresponda

      $this->tempLotes[] = [
        'lote' => $lote->toArray(),
        'precio_final' => $lote->precio_base,
        'moneda_id' => $monedaId,
        'moneda_signo' => $lote->ultimoConLote->moneda->signo ?? '$', // Guardar el signo también
        'moneda_titulo' => $lote->ultimoConLote->moneda->titulo ?? 'Pesos' // Guardar el título
      ];
      $this->recalcularTotales();
    }

    $this->search = '';
    $this->lotes = [];
    $this->si = false;
  }

  public function quitar($loteId)
  {
    if ($this->method == 'add') {
      // En creación nueva, simplemente quitamos de tempLotes
      $this->tempLotes = array_filter($this->tempLotes, function ($item) use ($loteId) {
        return $item['lote']['id'] != $loteId;
      });
    } else {
      // En edición, usar la lógica existente
      if (!in_array($loteId, $this->lotesEliminadosTemporales)) {
        $this->lotesEliminadosTemporales[] = $loteId;
      }

      $this->tempLotes = array_filter($this->tempLotes, function ($item) use ($loteId) {
        return $item['lote']['id'] != $loteId;
      });

      $this->ordenSeleccionada = Orden::with([
        'lotes' => function ($query) {
          $query->whereNotIn('lote_id', $this->lotesEliminadosTemporales);
        },
        'lotes.lote'
      ])->find($this->id);
    }

    $this->recalcularTotales();
    $this->dispatch('lote-quitado', ['mensaje' => 'Lote quitado temporalmente. Guarda para confirmar.']);
  }

  protected function recalcularTotales()
  {
    if ($this->method == 'add') {
      $this->subtotal = array_sum(array_column($this->tempLotes, 'precio_final'));
      $this->total = max(0, $this->subtotal - $this->deposito);
      if ($this->envio) {
        $this->total += $this->envio;
      }
    } else {
      $this->subtotal = $this->ordenSeleccionada->lotes->sum('precio_final');
      $this->total = max(0, $this->subtotal - $this->deposito);
      if ($this->envio) {
        $this->total += $this->envio;
      }
    }
  }

  public function updatedEnvio()
  {
    if (!is_numeric($this->envio) || $this->envio < 0 || floor($this->envio) != $this->envio) {
      $this->envio = 0;
    }

    $this->envio = (int)$this->envio;
    $this->recalcularTotales();
  }

  public function updatedDeposito()
  {
    if (!is_numeric($this->deposito) || $this->deposito < 0 || floor($this->deposito) != $this->deposito) {
      $this->deposito = 0;
    }

    $this->deposito = (int)$this->deposito;
    $this->recalcularTotales();
  }


  public function create()
  {
    // Validaciones para creación
    $this->validate([
      'adquirente_id' => 'required|exists:users,id',
      'subasta_id' => 'required|exists:subastas,id',
      'tempLotes' => 'required|array|min:1',
    ], [
      'adquirente_id.required' => 'Seleccione un adquirente',
      'subasta_id.required' => 'Seleccione una subasta',
      'tempLotes.required' => 'Agregue al menos un lote a la orden',
    ]);

    // Crear la orden
    $orden = Orden::create([
      'adquirente_id' => $this->adquirente_id,
      'subasta_id' => $this->subasta_id,
      'estado' => $this->estado ?? 'pendiente',
      'envio' => $this->envio ?? 0,
      'fecha_pago' => $this->fecha,
      'payment_id' => $this->payment,
      'total' => $this->total ?? null,
    ]);

    // Agregar los lotes a la orden
    foreach ($this->tempLotes as $item) {
      $orden->lotes()->create([
        'lote_id' => $item['lote']['id'],
        'precio_final' => $item['precio_final'],
        'moneda_id' => $item['moneda_id'] ?? 1,
      ]);

      // Actualizar estado del lote
      Lote::where('id', $item['lote']['id'])->update([
        'estado' => LotesEstados::VENDIDO
      ]);
    }

    $this->dispatch("ordenCreated");
  }

  public function update()
  {
    // Validar que al menos quede un lote si no está cancelada
    if ($this->estado !== 'cancelada' && count($this->tempLotes) === 0) {
      $this->addError('tempLotes', 'La orden debe tener al menos un lote');
      return;
    }

    // Eliminar pivots para lotes removidos
    foreach ($this->lotesEliminadosTemporales as $loteId) {
      $this->ordenSeleccionada->lotes()->where('lote_id', $loteId)->delete();

      $lote = Lote::find($loteId);
      if ($lote) {
        $lote->update(['estado' => LotesEstados::STANDBY]);
      }
    }

    $this->ordenSeleccionada->update([
      'estado' => $this->estado,
      'motivo' => $this->motivo ?? null,
      'otro' => $this->otroMotivo ?? null,
      'monto_envio' => $this->envio ?? 2,
      'descuento' => $this->deposito ?? 0,
      'fecha_pago' => $this->fecha ?? null,
      'payment_id' => $this->payment ?? null,
      'total' => $this->total ?? null,
    ]);

    // Limpiar temporales y recargar
    $this->lotesEliminadosTemporales = [];
    $this->ordenSeleccionada->refresh();
    // $this->tempLotes = $this->ordenSeleccionada->lotes->toArray();

    $this->dispatch("ordenUpdated");
  }

  public function render()
  {
    return view('livewire.admin.ordenes.modal');
  }
}
