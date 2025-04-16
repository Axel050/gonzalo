<?php

namespace App\Livewire\Admin\Auxiliares\EstadoLotes;

use App\Models\EstadosLote;
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
      $cond = EstadosLote::find($id);
      if (!$cond) {
        $this->dispatch('estadoNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['estadoCreated', 'estadoUpdated', 'estadoDeleted'])]
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
          $estados = EstadosLote::where("id", "like", '%' . $this->query . '%');
          break;
        case 'titulo':
          $estados = EstadosLote::where("titulo", "like", '%' . $this->query . '%');
          break;
        case 'todos':
          $estados = EstadosLote::where("id", "like", '%' . $this->query . '%')
            ->orWhere("titulo", "like", '%' . $this->query . '%');
          break;
      }
      $estados = $estados->orderBy("id", "desc")->paginate(10);
    } else {
      $estados = EstadosLote::orderBy("id", "desc")->paginate(10);
    }


    return view('livewire.admin.auxiliares.estado-lotes.index', compact("estados"));
  }
}
