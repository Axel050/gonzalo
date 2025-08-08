<?php

namespace App\Livewire;

use App\Models\Lote;
use App\Models\Subasta;
use App\Services\CarritoService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Livewire\Attributes\On;
use Livewire\Component;

class DetalleLote extends Component
{
  public $id;
  public $subasta;
  public $lote;
  public $own = false;
  public $adquirente;
  public $base;
  public $ultimaOferta;
  public $pujado;

  public $second = "anda";

  public $lote_id;
  public $subasta_id;

  public $method;


  // #[On('echo:my-channel.{subasta.id},SubastaEstadoActualizado')]

  #[On('echo:my-channel,PujaRealizada')]
  public function test($event)
  {
    if (isset($event['loteId']) && $this->lote?->id !== $event['loteId']) {
      return;
    }

    $this->ultimaOferta = $event['monto'];
    // $this->ultimaOferta = $this->lote?->getPujaFinal()?->monto;
    $this->lote = Lote::find($this->id);
    $this->dispatch('lotes-updated');
  }

  #[On('echo:my-channel,SubastaEstado')]
  public function reloadLotes()
  {
    $this->lote = Lote::find($this->id);
    $this->dispatch('lotes-updated');
  }



  public function addCarrito(CarritoService $carritoService)
  {
    try {
      $carritoService->agregar(
        $this->adquirente->id,
        $this->lote->id
      );
      session()->flash('message', 'Lote agregado correctamente al carrito.');
    } catch (ModelNotFoundException | InvalidArgumentException | DomainException $e) {
      $this->addError('puja', $e->getMessage());
    } catch (\Exception $e) {
      info('Error en Livewire::addCarrito', ['exception' => $e]);
      $this->addError('puja', 'Error interno al agregar el lote.');
    }
  }



  public function mount()
  {
    $this->adquirente = auth()->user()?->adquirente;
    $this->subasta = Subasta::find(9);
    $this->lote = Lote::find($this->id);
    $this->base = $this->lote?->precio_base;
    $this->ultimaOferta = $this->lote?->getPujaFinal()?->monto;
    info(["mouit Detalle lote" => $this->lote?->getPujaFinal()?->monto]);

    $this->lote_id = $this->lote->id;
    $this->subasta_id = $this->lote?->ultimoContrato?->subasta_id;

    // if ($this->lote?->getPujaFinal()?->adquirente_id == $this->adquirente?->id) {
    //   $this->own = true;
    // }
  }



  public function render()
  {
    return view('livewire.detalle-lote');
  }
}
