<?php

namespace App\Livewire\Admin\Auxiliares\Monedas;

use App\Models\Moneda;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
  use WithPagination;

  public $query, $nombre, $id;
  public $method = "";
  public $searchType = "todos";
  public $inputType = "search";

  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view") {
      $cond = Moneda::find($id);
      if (!$cond) {
        $this->dispatch('monedaNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['monedaCreated', 'monedaUpdated', 'monedaDeleted'])]
  public function mount()
  {
    $this->method = "";
    $this->resetPage();
  }

  public function render()
  {


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $monedas = Moneda::where("id", "like", '%' . $this->query . '%');
          break;
        case 'titulo':
          $monedas = Moneda::where("titulo", "like", '%' . $this->query . '%');
          break;
        case 'todos':
          $monedas = Moneda::where("id", "like", '%' . $this->query . '%')
            ->orWhere("titulo", "like", '%' . $this->query . '%');
          break;
      }
      $monedas = $monedas->orderBy("id", "desc")->paginate(10);
    } else {
      $monedas = Moneda::orderBy("id", "desc")->paginate(10);
    }


    return view('livewire.admin.auxiliares.monedas.index', compact("monedas"));
  }
}
