<?php

namespace App\Livewire;

use App\Models\Adquirente;
use Livewire\Attributes\On;
use Livewire\Component;

class Notificaciones extends Component
{
  #[On('echo:my-channel,PujaRealizada')]
  public function mostrarNotificacion($event)
  {
    // info(["TE ALL" => $event]);
    $user = auth()->user();

    if (!$user) {
      return; // invitado no logueado, no notificamos
    }

    $adquirente = Adquirente::where("user_id", $user->id)->first();

    // 🔹 Comprueba si el adquirente actual es el mismo que fue superado
    if ($adquirente && $adquirente->id == $event['ultimoAdquirente']) {
      // Aquí sí despachamos el evento interno para mostrar el toast/notificación      
      // $this->dispatch('nueva-puja', $event);
      $this->dispatch('nueva-puja', loteId: $event['loteId'], monto: $event['monto'], ultimoAdquirente: $event['ultimoAdquirente'], signo: $event['signo']);
    } else {
    }
  }

  public function render()
  {
    return view('livewire.notificaciones');
  }
}
