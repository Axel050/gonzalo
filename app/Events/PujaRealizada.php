<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Subasta;
use App\Services\SubastaService;


class PujaRealizada implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  /**
   * Create a new event instance.
   */
  public $subasta;
  public $estado;
  public $lotes;
  public $loteId;
  public $monto;

  public function __construct($loteId = null, $monto = null)
  {
    $this->loteId = $loteId;
    $this->monto = $monto;
  }
  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */
  public function broadcastOn2(): array
  {
    return [
      new PrivateChannel('channel-name'),
    ];
  }

  public function broadcastOn(): array
  {
    info("ENVENTO  PUJA");
    return [
      // new Channel('my-channel' . 9),
      new Channel('my-channel'),
      // new Channel('subasta.' . $this->subasta->id),
    ];
  }


  public function broadcastWith()
  {
    return [
      'loteId' => $this->loteId,
      'monto' => $this->monto,
    ];
  }
  //   info("ENVEN WWW");
  //   return [
  //     'subasta_id' => $this->subasta->id,
  //     'estado' => $this->estado,
  //     'lotes' => $this->lotes,
  //   ];
  //   // return [
  //   //   'subasta_id' => $this->subasta->id,
  //   //   'estado' => $this->estado,
  //   //   'lotes' => $this->lotes,
  //   // ];
  // }
}
