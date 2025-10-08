<?php

namespace App\Livewire;

use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Moneda;
use App\Services\CarritoService;
use App\Services\PujaService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Livewire\Attributes\On;
use Livewire\Component;

class PantallaPujas extends Component
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

  public $tieneOrdenes;

  #[On('echo:my-channel,SubastaEstado')]
  public function test2()
  {
    $this->lotes  = $this->adquirente?->carrito?->lotes;
    $this->dispatch('lotes-updated');
  }



  #[On('echo:my-channel,PujaRealizada')]
  public function test($event)
  {
    $id = $event["loteId"];
    if (isset($this->lotes)) {
      $lote = $this->lotes->firstWhere('id', $id);
      if ($lote) {
        $fra = $lote->fraccion_min;
        $this->ofertas[$id] = $event["monto"] + $fra;
        $this->dispatch('lotes-updated');
      }
    }

    // $this->lotes  = $this->adquirente?->carrito?->lotes;
    // $this->dispatch('lotes-updated');
  }






  #[On('timer-expired')]
  public function expired($loteId)
  {
    info("TERMINOoooooooo " . $loteId);
    $this->lotes  = $this->adquirente?->carrito?->lotes;
    // info("lotes SHOW" . $this->lotes);

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

  public function formatOffer($value, $loteId)
  {
    info("oooooooofeee");
    // dd("ad8a");
    // Limpiar el valor eliminando caracteres no numéricos
    $cleanValue = preg_replace('/[^0-9]/', '', $value);
    // Formatear con separadores de miles en español
    $this->ofertas[$loteId] = number_format((int) $cleanValue, 0, ',', '.');
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
        $actual = optional($lote->getPujaFinal())->monto !== null ? (int) $lote->getPujaFinal()->monto : 0;
        // $this->ofertas[$lote->id] = number_format($actual + $lote->fraccion_min, 0, ',', '.');
        if (!$actual) {
          $this->ofertas[$lote->id] = $lote->precio_base;
        } else {
          # code...
          $this->ofertas[$lote->id] = $actual + $lote->fraccion_min;
        }
      }
    }


    $this->tieneOrdenes = $this->adquirente->ordenes()->where("estado", "pendiente")->exists();
  }


  // public function registrarPuja(PujaService $pujaService, $loteId, $ultimoMontoVisto, $monto = null)
  // {



  //   // $this->ofertas[$loteId] = 12222;
  // }
  #[On('registrarPujaModal')]
  public function registrarPuja(PujaService $pujaService, $loteId, $ultimoMontoVisto, $monto = null)
  {

    // $this->ofertas[$loteId] = 12222;
    try {


      $fraccion = $this->fraccion_min[$loteId] ?? null;

      if ($monto) {
        $oferta = $monto;
      } else {
        $oferta = $this->ofertas[$loteId]   ?? null;
      }

      $totalMin = $fraccion + $ultimoMontoVisto;


      $valorLimpio = str_replace('.', '', $this->ofertas[$loteId]);

      // info([
      //   "SHIOW" => $ultimoMontoVisto,
      //   "oferta" => $oferta,
      //   "totla" => $totalMin,
      //   "valorLimpio" => $valorLimpio,

      // ]);


      // ✅ Validación: debe ser un entero positivo
      // if ($oferta < $totalMin) {
      // if (!is_numeric($valorLimpio) || intval($valorLimpio) != $valorLimpio || $valorLimpio <  1 || $valorLimpio < $totalMin) {
      if (!is_numeric($valorLimpio) || intval($valorLimpio) != $valorLimpio || $valorLimpio <  1) {
        $this->addError('puja.' . $loteId, 'Oferta invalida.');
        // $this->ofertas[$loteId] = 122;
        info(["aaaa" => $this->ofertas[$loteId]]);
        // $this->dispatch('error-puja', loteId: $loteId, mensaje: 'Oferta inválida');
        $this->ofertas[$loteId] = $totalMin;
        return;
      }
      // dd($totalMin);
      // info(["SHIOW" => $ultimoMontoVisto]);



      $result = $pujaService->registrarPuja(
        $this->adquirente?->id,
        $loteId,
        $valorLimpio,
        $ultimoMontoVisto
      );

      session()->flash('success', 'Puja registrada correctamente.');
      $this->dispatch('existo-puja', monto: $result['message']['monto_final']);
      $this->pujado = true;
      $this->ultimaOferta = $result['message']['monto_final'];
      // $this->fraccion_min[$loteId] = $this->lotes->firstWhere('id', $loteId)?->fraccion_min;
      $this->ofertas[$loteId] = "";
    } catch (ModelNotFoundException | InvalidArgumentException | DomainException $e) {
      if ($ultimoMontoVisto == 0) {
        $base = Lote::find($loteId)->precio_base;
        $this->ofertas[$loteId] = $base;
      } else {
        # code...
        $this->ofertas[$loteId] = $totalMin;
      }

      $this->addError('puja.' . $loteId, $e->getMessage());
      // $this->dispatch('error-puja', loteId: $loteId, mensaje: $e->getMessage());
      info('Error en Livewire::registrarPujaxxxx', ['exception' => $e]);
    } catch (\Exception $e) {
      $this->ofertas[$loteId] = $totalMin;
      info('Error en Livewire::registrarPuja', ['exception' => $e]);
      $this->addError('puja.' . $loteId, 'Error al pujar.');
      // $this->dispatch('error-puja', loteId: $loteId, mensaje: "error al pujar");
    }
  }




  // public function quitar(CarritoService $carritoService, int $loteId)
  // {
  //   $this->addError('quitar.' . $loteId, 'Tu oferta es la ultima.');
  // }
  public function quitar(CarritoService $carritoService, int $loteId)
  {

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
      $this->addError('quitar.' . $loteId, $e->getMessage());
      // $this->addError('quitar.19', $e->getMessage());
      // info(["lote id " => $loteId]);
      info('Error en Livxxxxewire::quitar', ['exception' => $e->getMessage()]);
    } catch (\Exception $e) {
      info('Error en Livewire::quitar', ['exception' => $e->getMessage()]);
      $this->addError('quitar.' . $loteId, 'Error interno al quitar el lote.');
    }
  }


  public function render()
  {
    return view('livewire.pantalla-pujas');
  }
}
