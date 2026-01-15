<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;




class PujaRealizada implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  /**
   * Create a new event instance.
   */

  public $loteId;
  public $monto;
  public $ultimoAdquirente;
  public $signo;
  public $adquirenteId;
  public $tiempoFinalizacion;


  public function __construct($loteId = null, $monto = null, $puja = null, $ultimoAdquirente = null, $signo = null, $adquirenteId = null, $tiempoFinalizacion = null)
  {
    // info("ENVENTO  PUJA COSNTRUC");
    $this->loteId = $loteId;
    $this->monto = $monto;
    $this->ultimoAdquirente = $ultimoAdquirente;
    $this->signo = $signo;
    $this->adquirenteId = $adquirenteId;
    $this->tiempoFinalizacion = $tiempoFinalizacion;
  }
  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */


  public function broadcastOn(): array
  {
    // info("ENVENTO  PUJA");
    return [
      new Channel('my-channel'),
      // new Channel('subasta.' . $this->subasta->id),
    ];
  }


  public function broadcastWith()
  {
    info("ENVENTO  PUJA with");

    return [
      'loteId' => $this->loteId,
      'monto' => $this->monto,
      'ultimoAdquirente' => $this->ultimoAdquirente,
      'signo' => $this->signo,
      'adquirenteId' => $this->adquirenteId,
      'tiempoFinalizacion' => $this->tiempoFinalizacion,

    ];
  }
}
