<?php

namespace App\Livewire\Admin\Auxiliares\Motivos;

use Livewire\Component;
use App\Models\MotivoDevolucion;
use Livewire\Attributes\On;

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
      $cond = MotivoDevolucion::find($id);
      if (!$cond) {
        $this->dispatch('motivoNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['motivoCreated', 'motivoUpdated', 'motivoDeleted'])]
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
          $motivos = MotivoDevolucion::where("id",  $this->query);
          break;
        case 'nombre':
          $motivos = MotivoDevolucion::where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'todos':
          $motivos = MotivoDevolucion::where("id", $this->query)
            ->orWhere("nombre", "like", '%' . $this->query . '%');
          break;
      }
      $motivos = $motivos->orderBy("id", "desc")->paginate(10);
    } else {
      $motivos = MotivoDevolucion::orderBy("id", "desc")->paginate(10);
    }


    return view('livewire.admin.auxiliares.motivos.index', compact("motivos"));
  }
}
