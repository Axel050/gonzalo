<?php

namespace App\Livewire;

use App\Services\SubastaService;
use Livewire\Component;

class DestacadosPantallaPujas extends Component
{
  protected $subastaService;

  public function render(SubastaService $subastaService)
  {

    $destacados = $subastaService?->getLotesActivosDestacadosHomeFoto()->toArray();

    return view('livewire.destacados-pantalla-pujas', compact("destacados"));
  }
}
