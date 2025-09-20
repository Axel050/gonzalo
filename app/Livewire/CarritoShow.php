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



  public $baseModal;


  public $modal;
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
    info("PEJA REEEEEE");
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




  public function modalOpen($loteId, $base)
  {
    info("modalalalalal");
    $this->baseModal = $base;
    $this->modal = $loteId;
  }


  public function mount()
  {
    // info("mount_ CarritoShow");
    $user  = auth()->user();
    $this->adquirente = Adquirente::where("user_id", $user->id)->first();
    $this->adquirente_id = $this->adquirente?->id;
    $this->lotes  = $this->adquirente?->carrito?->lotes;
    // info("lotes SHOW" . $this->lotes);
    $this->monedas = Moneda::all();

    if ($this->lotes) {
      foreach ($this->lotes as $lote) {
        $this->fraccion_min[$lote->id] = $lote->fraccion_min;
      }
    }
  }


  #[On('registrarPujaModal')]
  public function registrarPuja(PujaService $pujaService, $loteId, $ultimoMontoVisto, $monto = null)
  {
    try {


      $fraccion = $this->fraccion_min[$loteId] ?? null;

      if ($monto) {
        $oferta = $monto;
      } else {
        $oferta = $this->ofertas[$loteId] ?? null;
      }




      // ✅ Validación: debe ser un entero positivo
      if (!is_numeric($oferta) || intval($oferta) != $oferta || $oferta <  1 || $oferta < $fraccion || $oferta < 1) {
        $this->addError('puja.' . $loteId, 'Oferta invalida.');
        $this->dispatch('error-puja', loteId: $loteId, mensaje: 'Oferta inválida');
        // $this->fraccion_min[$loteId] = $this->adquirente?->carrito?->lotes?->firstWhere('id', $loteId)?->fraccion_min;
        // $this->fraccion_min[$loteId] = $this->lotes->firstWhere('id', $loteId)?->fraccion_min;
        return;
      }

      info(["SHIOW" => $ultimoMontoVisto]);


      $result = $pujaService->registrarPuja(
        $this->adquirente?->id,
        $loteId,
        $oferta,
        $ultimoMontoVisto
      );

      session()->flash('success', 'Puja registrada correctamente.');
      $this->dispatch('existo-puja', monto: $result['message']['monto_final']);
      $this->pujado = true;
      $this->ultimaOferta = $result['message']['monto_final'];
      // $this->fraccion_min[$loteId] = $this->lotes->firstWhere('id', $loteId)?->fraccion_min;
      $this->ofertas[$loteId] = "";
    } catch (ModelNotFoundException | InvalidArgumentException | DomainException $e) {
      $this->addError('puja.' . $loteId, $e->getMessage());
      $this->dispatch('error-puja', loteId: $loteId, mensaje: $e->getMessage());
      info('Error en Livewire::registrarPujaxxxx', ['exception' => $e]);
    } catch (\Exception $e) {
      info('Error en Livewire::registrarPuja', ['exception' => $e]);
      $this->addError('puja.' . $loteId, 'Error al pujar.');
      $this->dispatch('error-puja', loteId: $loteId, mensaje: "error al pujar");
    }
  }




  public function quitar(CarritoService $carritoService, int $loteId)
  {
    $this->addError('quitar.' . $loteId, 'Tu oferta es la ultima.');
  }
  public function quitar2(CarritoService $carritoService, int $loteId)
  {

    $this->addError('quitarx.' . $loteId, 'quitarxquitarx al pujar.');
    $this->addError('quitarx.' . $loteId, 'Adqaed8a8d8ed8aeuirente no especificadaao.');
    if (!$this->adquirente) {
      $this->addError('quitar.' . $loteId, 'Adquirente no especificadaao.');
      return;
    }

    try {
      $carritoService->quitar(
        $this->adquirente->id,
        $loteId,
      );

      $this->lotes  = $this->adquirente?->carrito?->lotes;
    } catch (ModelNotFoundException | InvalidArgumentException $e) {
      // $this->addError('quitar.' . $loteId, $e->getMessage());
      $this->addError('quitar.15', $e->getMessage());
      info(["lote id " => $loteId]);
      info('Error en Livxxxxewire::quitar', ['exception' => $e->getMessage()]);
    } catch (\Exception $e) {
      info('Error en Livewire::quitar', ['exception' => $e->getMessage()]);
      $this->addError('quitar.' . $loteId, 'Error interno al quitar el lote.');
    }
  }


  public function render()
  {
    return view('livewire.carrito-show');
  }
}
