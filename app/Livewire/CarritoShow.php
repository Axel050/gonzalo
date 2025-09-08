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

class CarritoShow extends Component
{
  public array $fraccion_min = [];
  public array $ofertas = [];


  public $adquirente;
  public $lotes;
  public $lote_id;
  public $carrito;
  public $adquirente_id;

  public $own = false;
  public $ultimaOferta;
  public $pujado;
  public $monedas;


  #[On('echo:my-channel,SubastaEstado')]
  public function test2()
  {
    $this->lotes  = $this->adquirente?->carrito?->lotes;
    $this->dispatch('lotes-updated');
  }

  #[On('echo:my-channel,PujaRealizada')]
  public function test($event)
  {
    $this->lotes  = $this->adquirente?->carrito?->lotes;
    $this->dispatch('lotes-updated');
  }



  #[On('timer-expired')]
  public function expired($loteId)
  {
    info("TERMINOoooooooo " . $loteId);
    $this->lotes  = $this->adquirente?->carrito?->lotes;
    info("lotes SHOW" . $this->lotes);

    if ($this->lotes) {
      foreach ($this->lotes as $lote) {
        $this->fraccion_min[$lote->id] = $lote->fraccion_min;
      }
    }


    // event(new PujaRealizada($lote->id, $montoFinal, $puja->id));


  }
  // $this->lotes  = $this->adquirente?->carrito?->lotes;
  public function ddd()
  {
    $this->dispatch('lotes-updated');
  }


  public function getMonedaSigno($id)
  {

    return $this->monedas->firstWhere('id', $id)?->signo ?? '';
  }


  public function mount()
  {
    info("mount_ CarritoShow");
    $user  = auth()->user();
    $this->adquirente = Adquirente::where("user_id", $user->id)->first();
    $this->adquirente_id = $this->adquirente?->id;
    $this->lotes  = $this->adquirente?->carrito?->lotes;
    info("lotes SHOW" . $this->lotes);
    $this->monedas = Moneda::all();

    if ($this->lotes) {
      foreach ($this->lotes as $lote) {
        $this->fraccion_min[$lote->id] = $lote->fraccion_min;
      }
    }
  }



  public function registrarPuja(PujaService $pujaService, $loteId)
  {

    try {
      info("CARRITO-SHOW  registrarPuja TRY");
      // dd($this->ofertas[$loteId]);


      $fraccion = $this->fraccion_min[$loteId] ?? null;
      $oferta = $this->ofertas[$loteId] ?? null;




      // ✅ Validación: debe ser un entero positivo
      if (!is_numeric($oferta) || intval($oferta) != $oferta || $oferta <  1 || $oferta < $fraccion || $oferta < 1) {
        $this->addError('puja.' . $loteId, 'Oferta invalida.');
        // $this->fraccion_min[$loteId] = $this->adquirente?->carrito?->lotes?->firstWhere('id', $loteId)?->fraccion_min;
        // $this->fraccion_min[$loteId] = $this->lotes->firstWhere('id', $loteId)?->fraccion_min;
        return;
      }




      $result = $pujaService->registrarPuja(
        $this->adquirente?->id,
        $loteId,
        $oferta
      );

      session()->flash('success', 'Puja registrada correctamente.');
      $this->pujado = true;
      $this->ultimaOferta = $result['message']['monto_final'];
      // $this->fraccion_min[$loteId] = $this->lotes->firstWhere('id', $loteId)?->fraccion_min;
      $this->ofertas[$loteId] = "";
    } catch (ModelNotFoundException | InvalidArgumentException | DomainException $e) {
      $this->addError('puja.' . $loteId, $e->getMessage());
      info('Error en Livewire::registrarPujaxxxx', ['exception' => $e]);
    } catch (\Exception $e) {
      info('Error en Livewire::registrarPuja', ['exception' => $e]);
      $this->addError('puja.' . $loteId, 'Error al pujar.');
    }
  }




  public function quitar(CarritoService $carritoService, int $loteId)
  {

    if (!$this->adquirente) {
      $this->addError('qpuja.' . $loteId, 'Adquirente no especificadaao.');
      return;
    }

    try {
      $carritoService->quitar(
        $this->adquirente->id,
        $loteId,
      );

      $this->lotes  = $this->adquirente?->carrito?->lotes;
    } catch (ModelNotFoundException | InvalidArgumentException $e) {
      $this->addError('qpuja.' . $loteId, $e->getMessage());
    } catch (\Exception $e) {
      info('Error en Livewire::quitar', ['exception' => $e]);
      $this->addError('qpuja.' . $loteId, 'Error interno al quitar el lote.');
    }
  }


  public function render()
  {
    return view('livewire.carrito-show');
  }
}
