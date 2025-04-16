<?php

namespace App\Livewire\Admin\Depositos;

use App\Models\Deposito;
use App\Models\Subasta;
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
    if ($method == "delete" || $method == "update" || $method == "view") {
      $cond = Deposito::find($id);
      if (!$cond) {
        $this->dispatch('depositoNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['depositoCreated', 'depositoUpdated', 'depositoDeleted'])]
  public function mount()
  {
    if ($this->ids) {
      $exists = Subasta::where('id', $this->ids)->exists();
      if ($exists) {
        $this->searchType = "subasta";
        $this->query = $this->ids;
      } else {
        $this->searchType = "todos";
        $this->query = "";
      }
    }

    $this->method = "";
    $this->resetPage();
  }

  public function render()
  {


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $depositos = Deposito::where("id", "like", '%' . $this->query . '%');
          break;
        case 'adquirente':
          $depositos = Deposito::whereHas('adquirente', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
            $query->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
        case 'fecha':
          $depositos = Deposito::where("fecha", "like", '%' . $this->query . '%');
          break;
        case 'fecha_devolucion':
          $depositos = Deposito::where("fecha_devolucion", "like", '%' . $this->query . '%');
          break;
        case 'subasta':
          $depositos = Deposito::where("subasta_id", "like", '%' . $this->query . '%');
          break;
        case 'estado':
          $depositos = Deposito::where("estado", "like", '%' . $this->query . '%');
          break;
        case 'todos':
          $depositos = Deposito::where("id", "like", '%' . $this->query . '%')
            ->orWhere(".estado", "like", '%' . $this->query . '%')
            ->orWhereHas('adquirente', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
              $query->orWhere('apellido', 'like', '%' . $this->query . '%');
            })
            ->orWhere("fecha", "like", '%' . $this->query . '%')
            ->orWhere("fecha_devolucion", "like", '%' . $this->query . '%')
            ->orWhere("subasta_id", "like", '%' . $this->query . '%');
          break;
      }
      $depositos = $depositos->orderBy("id", "desc")->paginate(10);
    } else {
      $depositos = Deposito::orderBy("id", "desc")->paginate(10);
    }


    return view('livewire.admin.depositos.index', compact("depositos"));
  }
}
