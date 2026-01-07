<?php

namespace App\Livewire;

use App\Services\SubastaService;
use Livewire\Component;

class DestacadosPantallaPujas extends Component
{
  protected $subastaService;
  public $contador;

  public function render(SubastaService $subastaService)
  {

    $destacados = $subastaService?->getLotesActivosDestacadosHomeFoto()->toArray();
    $this->contador = ! empty($destacados);

    return view('livewire.destacados-pantalla-pujas', compact("destacados"));
  }
}
