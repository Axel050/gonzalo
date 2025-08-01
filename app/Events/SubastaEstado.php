<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;



class SubastaEstado implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  /**
   * Create a new event instance.
   */
  public $subasta;
  public $estado;
  public $lotes;

  public function __construct()
  {
    info("ENVEN -SUBASTA ESTADO vvv ");
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */


  public function broadcastOn(): array
  {
    info("ENVEN nRO ON000000");
    return [
      // new Channel('my-channel' . 9),
      new Channel('my-channel'),
      // new Channel('subasta.' . $this->subasta->id),
    ];
  }
}
