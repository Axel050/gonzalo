<?php

namespace App\Livewire;


use App\Models\Orden;
use App\Services\CarritoService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Carrito extends Component
{
  public array $fraccion_min = [];

  public array $envios = [];


  public $modalPago;
  public $adquirente;
  public $lotes;
  public $lote_id;
  public array $carrito = [];
  public $adquirente_id;

  public $own = false;
  public $ultimaOferta;
  public $pujado;
  public $monedas;

  public $orden;
  public $subasta;

  public $totalDepositos;


  public $total;
  public $conEnvio = 0;
  // public $envio_check = 0;






  public $totalLotes = 0;
  public $totalCarrito = 0;
  public $descuentoGarantias = 0;
  public $garantiasAplicadas = [];
  public $ordenes;


  // $this->carrito = $service->obtenerResumen($adquirente);+$dto = $service->obtener(auth()->user()->adquirente);

  public function mount(CarritoService $service)
  {
    $adquirente = Auth::user()->adquirente;

    $dto = $service->obtenerResumen($adquirente);

    $this->carrito = $dto->toArray();
  }




  public function moun22t()
  {
    info("Mount actualizado");

    // $user = auth()->user();
    $user  = Auth::user();

    $this->adquirente = $user->adquirente;

    // 🔹 Traemos las órdenes pendientes con su subasta y lotes
    $this->ordenes = $this->adquirente?->ordenes()
      ->where('estado', 'pendiente')
      ->with('subasta', 'lotes.lote.ultimoContrato') // Ya no 'lotes.subasta'
      ->get();

    foreach ($this->ordenes as $orden) {
      // $this->fraccion_min[$lote->id] = $lote->fraccion_min;
      $this->envios[$orden->id] = $orden->monto_envio;
    }
    info($this->envios);
    if (!$this->ordenes || $this->ordenes->isEmpty()) {
      $this->totalLotes = 0;
      $this->totalCarrito = 0;
      $this->garantiasAplicadas = [];
      $this->descuentoGarantias = 0;
      $this->lotes = collect();
      return;
    }

    // 🔹 Extraer todos los lotes de las órdenes pendientes
    $this->lotes = $this->ordenes->flatMap->lotes->all();

    // 🔹 Total de todos los lotes en las órdenes pendientes
    $this->totalLotes = $this->ordenes->flatMap->lotes->sum('precio_final');

    // 🔹 Agrupar por subasta, pero ahora a nivel de orden
    $grupos = $this->ordenes->groupBy('subasta_id');

    $this->garantiasAplicadas = [];
    $this->descuentoGarantias = 0;

    foreach ($grupos as $subastaId => $ordenesSubasta) {
      if (empty($subastaId)) continue;

      // Buscar garantía pagada asociada a esa subasta
      $garantia = $this->adquirente->garantias()
        ->where('subasta_id', $subastaId)
        ->where('estado', 'pagado')
        ->first();

      if ($garantia) {
        $monto = (float) $garantia->monto;
        $this->descuentoGarantias += $monto;

        // 🔹 Accedemos al título de la subasta desde la orden (ya no desde los lotes)
        $this->garantiasAplicadas[] = [
          'subasta_id'     => $subastaId,
          'subasta_titulo' => $ordenesSubasta->first()->subasta?->titulo, // ✅ corregido
          'monto'          => $monto,
        ];
      }
    }

    // 🔹 Calcular total con descuentos
    $this->totalCarrito = max(0, $this->totalLotes - $this->descuentoGarantias);
  }








  public function mp($orden_id)
  {

    $this->orden = Orden::with('lotes.lote', 'subasta', 'adquirente')->findOrFail($orden_id);

    // $adquirente = $orden->adquirente;
    $this->subasta = $this->orden->subasta;


    if ($this->orden->total_neto < 0) {
      $this->addError('monto', "Error en el monto de la orden.");
      return;
    }


    // $this->conEnvio = $this->envios[$orden_id] ? 1 : 0;

    $orden = Orden::find($orden_id);

    $this->conEnvio =  $orden->subasta?->envio;
    $this->modalPago = 1;

    // Creamos preferencia desde el servicio
    // $preference = $mpService->crearPreferenciaOrden(
    //   $adquirente,
    //   $subasta,
    //   $orden,
    // );


    // $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente->id, $this->subasta->id, null,  $route);
    // $preference = $mpService->crearPreferencia("Garantia", 1, $this->subasta->garantia, $this->adquirente->id, 66, null,  $route);

    // if ($preference) {
    //   return redirect()->away($preference->init_point);
    // }


    // info(
    // return redirect($preference['init_point']); // Redirige al checkout
  }


  public function render()
  {
    return view('livewire.carrito');
  }
}
