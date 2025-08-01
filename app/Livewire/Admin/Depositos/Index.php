<?php

namespace App\Livewire\Admin\Depositos;


use App\Models\Garantia;
use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
  use WithPagination;

  public $sortField = 'id';
  public $sortDirection = 'desc'; //

  public $query, $nombre, $id;
  public $method = "";
  public $searchType = "todos";
  public $inputType = "search";

  #[Url]
  public $ids;

  public function sortBy($field)
  {
    if ($this->sortField === $field) {
      $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
      $this->sortField = $field;
      $this->sortDirection = 'asc';
    }
    $this->resetPage(); // Reinicia la paginación al cambiar el orden
  }


  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view") {
      $cond = Garantia::find($id);
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
          $depositos = Garantia::where("depositos.id", "like", '%' . $this->query . '%');
          break;
        case 'adquirente':
          $depositos = Garantia::whereHas('adquirente', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
            $query->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
        case 'alias':
          $depositos = Garantia::whereHas('adquirente.alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'fecha':
          $depositos = Garantia::where("fecha", "like", '%' . $this->query . '%');
          break;
        case 'fecha_devolucion':
          $depositos = Garantia::where("fecha_devolucion", "like", '%' . $this->query . '%');
          break;
        case 'subasta':
          $depositos = Garantia::where("subasta_id", "like", '%' . $this->query . '%');
          break;
        case 'estado':
          $depositos = Garantia::where("estado", "like", '%' . $this->query . '%');
          break;
        case 'todos':
          $depositos = Garantia::where("depositos.id", "like", '%' . $this->query . '%')
            ->orWhere("estado", "like", '%' . $this->query . '%')
            ->orWhereHas('adquirente', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
              $query->orWhere('apellido', 'like', '%' . $this->query . '%');
            })
            ->orWhereHas('adquirente.alias', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
            })
            ->orWhere("fecha", "like", '%' . $this->query . '%')
            ->orWhere("fecha_devolucion", "like", '%' . $this->query . '%')
            ->orWhere("subasta_id", "like", '%' . $this->query . '%');
          break;
      }

      // Aplicar ordenamiento dinámico
      if ($this->sortField === 'adquirente') {
        $depositos = $depositos->join('adquirentes', 'depositos.adquirente_id', '=', 'adquirentes.id')
          ->orderBy('adquirentes.nombre', $this->sortDirection)
          ->select('depositos.*');
      } else {
        $depositos = $depositos->orderBy($this->sortField, $this->sortDirection);
      }
      $depositos = $depositos->paginate(15);
    } else {
      // Ordenamiento para cuando no hay búsqueda
      if ($this->sortField === 'adquirente') {
        $depositos = Garantia::join('adquirentes', 'depositos.adquirente_id', '=', 'adquirentes.id')
          ->orderBy('adquirentes.nombre', $this->sortDirection)
          ->select('depositos.*')
          ->paginate(15);
      } else {
        $depositos = Garantia::orderBy($this->sortField, $this->sortDirection)->paginate(15);
      }
    }

    return view('livewire.admin.depositos.index', compact("depositos"));
  }
}
