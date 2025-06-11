<?php

namespace App\Livewire\Admin\Auxiliares\TipoBien;

use App\Models\TiposBien;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
  use WithPagination;

  public $query, $nombre, $id;
  public $method = "";
  public $searchType = "todos";
  public $inputType = "search";

  #[Url]
  public $ids;

  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view" || $method == "campos") {
      $cond = TiposBien::find($id);
      if (!$cond) {
        $this->dispatch('condicionNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['tipoCreated', 'tipoUpdated', 'tipoDeleted', 'campoCreated'])]
  public function mount()
  {
    if ($this->ids) {
      $this->query = $this->ids;
      $this->searchType = "id";
    }

    $this->method = "";
    $this->resetPage();
  }


  #[On(['campos'])]
  public function openAut($id = false)
  {
    $this->id = $id;
    $this->method = "campos";
  }


  public function render()
  {


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $tipos = TiposBien::where("id", "like", '%' . $this->query . '%');
          break;
        case 'nombre':
          $tipos = TiposBien::where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'encargado':
          $tipos = TiposBien::whereHas('encargado', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'suplente':
          $tipos = TiposBien::whereHas('suplente', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'todos':
          $tipos = TiposBien::where("id", "like", '%' . $this->query . '%')
            ->orWhere(".nombre", "like", '%' . $this->query . '%')
            ->orWhereHas('encargado', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
            })
            ->orWhereHas('suplente', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
            });
          break;
      }
      $tipos = $tipos->orderBy("id", "desc")->paginate(10);
    } else {
      $tipos = TiposBien::orderBy("id", "desc")->paginate(10);
    }



    return view('livewire.admin.auxiliares.tipo-bien.index', compact("tipos"));
  }
}
