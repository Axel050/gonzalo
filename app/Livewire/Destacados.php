<?php

namespace App\Livewire;

use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\SubastaService;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Destacados extends Component
{


  public $route;

  public $titulo;

  #[Locked]
  public Subasta $subasta;
  public $subasta_id;
  public $monedas;
  public $lote;
  public $destacados;
  public $from;
  protected $subastaService;
  public $contador  = false;
  // protected $subastaService;
  // protected $subastaService;


  public function mount(SubastaService $subastaService, Subasta $subasta)
  {



    $this->subastaService = $subastaService;
    // $this->subasta = Subasta::find(15);
    $this->subasta = $subasta;
    $this->monedas = Moneda::all();
    // $this->lote = Lote::find(8);
    $this->loadLotes();
  }


  public function loadLotes()
  {
    try {


      if ($this->from == "home") {
        $this->destacados = $this->subastaService?->getLotesActivosDestacadosHome()->toArray();
        $this->contador = ! empty($this->destacados);
      } else {
        # code...


        // $this->destacados = $this->subastaService?->getLotesActivosDestacados($this->subasta)?->toArray();
        $metodo = match ($this->route) {
          'subasta-proximas.lotes'   => 'getLotesProximosDestacados',
          'subasta-pasadas.lotes'      => 'getLotesPasadosDestacados',
          default => 'getLotesActivosDestacados',
        };

        $this->destacados = $this->subastaService?->{$metodo}($this->subasta)?->toArray();
        // $this->destacados = [];

        $this->contador = ! empty($this->destacados);
      }
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
