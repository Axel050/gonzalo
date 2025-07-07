<?php

namespace App\Livewire\Admin\Auxiliares\Caracteristicas;

use App\Models\Caracteristica;
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
      $cond = Caracteristica::find($id);
      if (!$cond) {
        $this->dispatch('caracteristicaNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['caracteristicaCreated', 'caracteristicaUpdated', 'caracteristicaDeleted'])]
  public function mount()
  {
    $this->method = "";
    $this->resetPage();
  }

  public function updatingQuery()
  {
    $this->resetPage();
  }

  public function updatingSearchType()
  {
    $this->resetPage();
  }

  public function render()
  {


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $caracteristicas = Caracteristica::where("id", "like", '%' . $this->query . '%');
          break;
        case 'nombre':
          $caracteristicas = Caracteristica::where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'tipo':
          $caracteristicas = Caracteristica::where("tipo", "like", '%' . $this->query . '%');
          break;
        case 'todos':
          $caracteristicas = Caracteristica::where("id", "like", '%' . $this->query . '%')
            ->orWhere(".tipo", "like", '%' . $this->query . '%')
            ->orWhere(".nombre", "like", '%' . $this->query . '%');
          break;
      }
      $caracteristicas = $caracteristicas->orderBy("id", "desc")->paginate(15);
    } else {
      $caracteristicas = Caracteristica::orderBy("id", "desc")->paginate(15);
    }


    return view('livewire.admin.auxiliares.caracteristicas.index', compact("caracteristicas"));
  }
}
