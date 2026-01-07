<?php

namespace App\Livewire;

use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Moneda;
use App\Services\CarritoService;
use App\Services\PujaService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
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
  public $user;

  #[On('echo:my-channel,SubastaEstado')]
  public function test2(CarritoService $carritoService)
  {
    // info("SUBASTA ESTADO Evento");
    // $this->lotes  =$this->adquirente?->carrito?->lotesFiltrados;
    $this->loadLotes($carritoService);
    $this->dispatch('lotes-updated');
  }


  #[On('echo:my-channel,PujaRealizada')]
  public function test($event)
  {

    if ($event['adquirenteId'] == $this->user->adquirente->id) {
      return;
    }

    $id = $event["loteId"];
    $nuevoMonto = $event["monto"];

    $index = collect($this->lotes)->search(function ($lote) use ($id) {
      return $lote['id'] === $id;
    });

    // Si lo encuentra, actualizar solo ese elemento
    if ($index !== false) {

      info(["INDEX FINALIZA" => $event['tiempoFinalizacion']]);
      $this->lotes[$index]['tiempoFinalizacion'] = $event['tiempoFinalizacion'];
      $this->lotes[$index]['ofertaActual'] = $nuevoMonto;
      $this->lotes[$index]['esGanador'] = false;
      $this->lotes[$index]['ofertaActualFormateada'] = number_format($nuevoMonto, 0, ',', '.');
      $this->ofertas[$id] = $nuevoMonto + $this->lotes[$index]['fraccionMin'];
      // $this->dispatch('lotes-updated');
      $this->dispatch('lotes-updated', [
        'loteId' => $event['loteId'],
        'tiempoFinalizacion' => $event['tiempoFinalizacion']
      ]);
    }
  }





  #[On('timer-expired')]
  public function expired($loteId, CarritoService $carritoService)
  {
    $this->loadLotes($carritoService);
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


  public function mount(CarritoService $service)
  {

    $this->user  = Auth::user();
    $this->adquirente = $this->user->adquirente;
    $this->adquirente_id = $this->adquirente?->id;

    $this->loadLotes($service);

    $this->tieneOrdenes = $service->tieneOrdenesPendientes($this->adquirente);
  }




  #[On('registrarPujaModal')]
  public function registrarPuja(PujaService $pujaService, $loteId, $ultimoMontoVisto)
  {

    try {
      $valorLimpio = str_replace('.', '', $this->ofertas[$loteId]);

      $lo = Lote::find($loteId);
      $base = $lo->ultimoConLote?->precio_base;
      $fraccion = $lo->fraccion_min;
      $totalMin = $fraccion + $ultimoMontoVisto;

      if (
        $valorLimpio === '' ||
        !ctype_digit($valorLimpio) ||          // solo dígitos
        strlen($valorLimpio) > 10 ||
        (int) $valorLimpio < 1
      ) {
        $this->addError('puja.' . $loteId, 'Oferta inválidass');
        $valorF  = $ultimoMontoVisto == 0 ? $base  : $totalMin;

        $this->ofertas[$loteId] = number_format($valorF, 0, '', '.');
        return;
      }



      if (!is_numeric($valorLimpio) || intval($valorLimpio) != $valorLimpio || $valorLimpio <  1) {
        $this->addError('puja.' . $loteId, 'Oferta invalida.');
        return;
      }


      if ($ultimoMontoVisto == 0 && $base > $valorLimpio) {
        $this->addError('puja.' . $loteId, 'Monto minino.' . $base);
        $this->ofertas[$loteId] = $base;
        return;
      }


      if ($ultimoMontoVisto > 0 && $totalMin > $valorLimpio) {
        $this->addError('puja.' . $loteId, 'Monto minino.' . $totalMin);
        $this->ofertas[$loteId] = $totalMin;
        return;
      }


      $result = $pujaService->registrarPuja(
        $this->adquirente?->id,
        $loteId,
        $valorLimpio,
        $ultimoMontoVisto
      );
      -

      // session()->flash('success', 'Puja registrada correctamente.');

      $this->pujado = true;
      $this->ofertas[$loteId] = "";

      $index = collect($this->lotes)->search(function ($lote) use ($loteId) {
        return $lote['id'] === $loteId;
      });

      // Si lo encuentra, actualizar solo ese elemento
      if ($index !== false) {
        $this->lotes[$index]['ofertaActual'] = $result['message']['monto_final'];

        $this->lotes[$index]['ofertaActualFormateada'] = number_format($result['message']['monto_final'], 0, ',', '.');
        $this->lotes[$index]['esGanador'] = true;
        $this->lotes[$index]['tiempoFinalizacion'] = $result['message']['tiempoFinalizacion'];
      }

      $this->dispatch('lotes-updated');


      $this->dispatch('puja-exitosa', loteId: $loteId);
      $this->dispatch('puja-registrada', loteId: $loteId);
    } catch (ModelNotFoundException | InvalidArgumentException | DomainException $e) {
      if ($ultimoMontoVisto == 0) {

        // number_format($valorF, 0, '', '.');
        $this->ofertas[$loteId] = number_format($base, 0, '', '.');
      } else {
        # code...

        $this->ofertas[$loteId] = number_format($totalMin, 0, '', '.');
      }

      $this->addError('puja.' . $loteId, $e->getMessage());
      // $this->dispatch('error-puja', loteId: $loteId, mensaje: $e->getMessage());
      info('Error en Livewire::registrarPujaxxxx', ['exception' => $e]);
    } catch (\Exception $e) {
      $this->ofertas[$loteId] = number_format($totalMin, 0, '', '.');
      info('Error en Livewire::registrarPuja', ['exception' => $e]);
      $this->addError('puja.' . $loteId, 'Error al pujar.');
      // $this->dispatch('error-puja', loteId: $loteId, mensaje: "error al pujar");
    }
  }



  public function loadLotes(CarritoService $carritoService)
  {
    $this->lotes = $carritoService->getLotesDetallados($this->adquirente)
      ->map(function ($dto) {
        return (array) $dto;
      })
      ->toArray();


    foreach ($this->lotes as $lote) {
      $baseParaPujar = $lote['ofertaActual'] > 0 ? $lote['ofertaActual'] : $lote['precioBase'];

      $this->ofertas[$lote['id']] =  $lote['ofertaActual'] > 0 ? $baseParaPujar  + $lote['fraccionMin'] :  $baseParaPujar;
    }
  }



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


      $this->loadLotes($carritoService);
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
