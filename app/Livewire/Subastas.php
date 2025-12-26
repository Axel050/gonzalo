<?php

namespace App\Livewire;


use App\Models\Subasta;
use Carbon\Carbon;

use Livewire\Component;



class Subastas extends Component
{

  public $subastas;
  public $subastasProx;
  public $subastasFin;



  public function mount()
  {

    $this->subastas = Subasta::whereIn('estado', ["activa", "enpuja"])->get();

    $this->subastasProx = Subasta::where('fecha_inicio', '>=', Carbon::now())->get();


    $this->subastasFin = Subasta::whereIn('estado', ["finalizada"])->get();

    // info([
    //   "subasta" => count($this->subastas),
    //   "subastaProx" => count($this->subastasProx),
    //   "subastaFIN" => count($this->subastasFin),
    // ]);
  }






  public function render()
  {
    return view('livewire.subastas');
  }
}
