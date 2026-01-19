<?php

namespace App\Livewire;

use App\Http\Resources\SubastasHomeResource;
use App\Services\SubastaService;

use Livewire\Component;



class Subastas extends Component
{

  public $subastas;
  public $subastasProx;
  public $subastasFin;


  public function mount(SubastaService $service)
  {

    // dd(class_exists(SubastasHomeResource::class));
    $dtos = $service->activas();
    $this->subastas = SubastasHomeResource::collection($dtos)
      ->resolve();

    $dtosProx = $service->proximas();
    $this->subastasProx = SubastasHomeResource::collection($dtosProx)
      ->resolve();


    $dtosFin = $service->finalizadas();
    $this->subastasFin = SubastasHomeResource::collection($dtosFin)
      ->resolve();

    // $this->subastas      = $service->activas();
    // info(["subastas" => $this->subastas]);
    // $this->subastasProx     = $service->proximas();
    // $this->subastasFin  = $service->finalizadas();
  }





  public function mounsst()
  {


    // $this->subastas = Subasta::whereIn('estado', ["activa", "enpuja"])->get();

    // $this->subastasProx = Subasta::where('fecha_inicio', '>=', Carbon::now())->get();


    // $this->subastasFin = Subasta::whereIn('estado', ["finalizada"])->get();

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
