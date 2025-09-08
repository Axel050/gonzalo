<?php

namespace App\Livewire;

use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Component;

class Destacados extends Component
{


  public $route;

  public $titulo;
  public $subasta;
  public $subasta_id;
  public $monedas;
  public $lote;
  public $destacados;
  protected $subastaService;
  // protected $subastaService;


  public function mount(SubastaService $subastaService)
  {


    $this->subastaService = $subastaService;
    $this->subasta = Subasta::find($this->subasta_id);
    $this->monedas = Moneda::all();
    // $this->lote = Lote::find(8);
    $this->loadLotes();
  }


  public function loadLotes()
  {
    try {
      info("lotesClass");

      // match ($this->route) {
      //   'en_subasta' => 'subasta.lotes',
      //   'asignado' => 'subasta-proximas.lotes',
      //   default => 'subasta-pasadas.lotes'
      // };


      // $this->destacados = $this->subastaService?->getLotesActivosDestacados($this->subasta)?->toArray();
      $metodo = match ($this->route) {
        'subasta-proximas.lotes'   => 'getLotesProximosDestacados',
        'subasta-pasadas.lotes'      => 'getLotesPasadosDestacados',
        default => 'getLotesActivosDestacados',
      };

      $this->destacados = $this->subastaService?->{$metodo}($this->subasta)?->toArray();

      // info(["desssLIVE" => $this->destacados]);
      // info(["lotesClass" => $this->destacados]);
      // $this->error = null;
    } catch (\Exception $e) {
      // info(["error" => $this-}>destacados]);
      info(["errorrrr" => $e->getMessage()]);
      $this->destacados = [];
      // $this->error = $e->getMessage();
    }
  }



  public function render()
  {
    return view('livewire.destacados');
  }
}
