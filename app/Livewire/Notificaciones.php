<?php

namespace App\Livewire;

use App\Models\Adquirente;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Notificaciones extends Component
{
  #[On('echo:my-channel,PujaRealizada')]
  public function mostrarNotificacion($event)
  {
    $user  = Auth::user();

    if (!$user) {
      return; // invitado no logueado, no notificamos
    }

    $adquirente = $user?->adquirente;

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
