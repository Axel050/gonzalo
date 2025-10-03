<?php

namespace App\Livewire;

use App\Models\Adquirente;
use App\Models\Moneda;
use App\Services\CarritoService;
use App\Services\PujaService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Livewire\Attributes\On;
use Livewire\Component;

class Carrito extends Component
{
  public array $fraccion_min = [];


  public $adquirente;
  public $lotes;
  public $lote_id;
  public $carrito;
  public $adquirente_id;

  public $own = false;
  public $ultimaOferta;
  public $pujado;
  public $monedas;

  public $totalDepositos;


  public $total;
  // public $total;


  // public $descuentoGarantias = 0;
  // public $totalLotes = 0;
  // public $totalCarrito = 0;




  // public function mount()
  // {
  //   $user  = auth()->user();
  //   $this->adquirente = Adquirente::where("user_id", $user->id)->first();

  //   // dentro de mount()
  //   $this->lotes = $this->adquirente?->carrito?->lotes()
  //     ->where('estado', 'vendido')
  //     ->with('ultimoContrato.subasta')
  //     ->get()
  //     ->map(function ($lote) {
  //       $lote->actual = optional($lote->getPujaFinal())->monto ?? 0;
  //       return $lote;
  //     });

  //   $this->totalLotes = $this->lotes->sum('actual');

  //   // agrupo por id de subasta (puede dar null)
  //   $grupos = $this->lotes->groupBy(fn($lote) => $lote->ultimoContrato?->subasta?->id);

  //   $this->descuentoGarantias = 0;

  //   foreach ($grupos as $subastaId => $lotesSubasta) {
  //     if (empty($subastaId)) continue; // ignorar lotes sin subasta
  //     $this->descuentoGarantias += $this->adquirente->garantiaMonto((int)$subastaId);
  //   }

  //   $this->totalCarrito = max(0, $this->totalLotes - $this->descuentoGarantias);
  // }




  public $totalLotes = 0;
  public $totalCarrito = 0;
  public $descuentoGarantias = 0;
  public $garantiasAplicadas = [];

  public function mount()
  {
    $user  = auth()->user();
    $this->adquirente = Adquirente::where("user_id", $user->id)->first();

    $this->lotes = $this->adquirente?->carrito?->lotes()
      ->where('estado', 'vendido')
      ->with('ultimoContrato.subasta')
      ->get()
      ->map(function ($lote) {
        $lote->actual = optional($lote->getPujaFinal())->monto ?? 0;
        return $lote;
      });

    $this->totalLotes = $this->lotes->sum('actual');

    $grupos = $this->lotes->groupBy(fn($lote) => $lote->ultimoContrato?->subasta?->id);

    $this->garantiasAplicadas = [];
    $this->descuentoGarantias = 0;

    foreach ($grupos as $subastaId => $lotesSubasta) {
      if (empty($subastaId)) continue;

      $garantia = $this->adquirente->garantias()
        ->where('subasta_id', $subastaId)
        ->where('estado', 'pagado')
        ->first();

      if ($garantia) {
        $monto = (float) $garantia->monto;
        $this->descuentoGarantias += $monto;

        $this->garantiasAplicadas[] = [
          'subasta_id'     => $subastaId,
          'subasta_titulo' => $lotesSubasta->first()->ultimoContrato?->subasta?->titulo,
          'monto'          => $monto,
        ];
      }
    }

    info(["aaa" => $this->garantiasAplicadas]);
    $this->totalCarrito = max(0, $this->totalLotes - $this->descuentoGarantias);
  }


  public function render()
  {
    return view('livewire.carrito');
  }
}
