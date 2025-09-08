<?php

namespace App\Livewire;

use App\Models\Subasta;
use Livewire\Component;

class SubastasAbiertas extends Component
{
  public function render()
  {

    $subastasAct = Subasta::whereIn('estado', ["activa", "enpuja"])->get();

    if (!count($subastasAct)) {
      return "<div style='display:none'></div>";
    }

    return view('livewire.subastas-abiertas', compact("subastasAct"));
  }
}
