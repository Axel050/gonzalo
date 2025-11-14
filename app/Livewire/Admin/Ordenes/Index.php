<?php

namespace App\Livewire\Admin\Ordenes;

use App\Enums\OrdenesEstados;
use App\Models\Garantia;
use App\Models\Orden;
use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
  use WithPagination;

  public $estadoFilter;


  public $query, $nombre, $id;
  public $method = "";
  public $searchType = "todos";
  public $inputType = "search";
  public $estados = [];

  #[Url]
  public $ids;




  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view") {
      $cond = Orden::find($id);
      if (!$cond) {
        $this->dispatch('depositoNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "add") {
      $this->method = $method;
    }
  }


  #[On(['ordenCreated', 'ordenUpdated', 'depositoDeleted'])]
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

    $this->estados = array_map(function ($estado) {
      return [
        'value' => $estado,
        'label' => OrdenesEstados::getLabel($estado),
      ];
    }, OrdenesEstados::all());


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

    $ordenes = Orden::query();


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $ordenes->where('ordenes.id', 'like', '%' . $this->query . '%');
          break;

        case 'adquirente':
          $ordenes->whereHas('adquirente', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%')
              ->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;

        case 'estado':
          $ordenes->where('estado', 'like', '%' . $this->query . '%');
          break;

        case 'fecha_pago':
          $ordenes->where('fecha_pago', 'like', '%' . $this->query . '%');
          break;

        case 'subasta':
          $ordenes->where('subasta_id', 'like', '%' . $this->query . '%');
          break;

        case 'todos':
          $ordenes->where(function ($query) {
            $query->where('ordens.id', 'like', '%' . $this->query . '%')
              ->orWhere('fecha_pago', 'like', '%' . $this->query . '%')
              ->orWhere('subasta_id', 'like', '%' . $this->query . '%')
              ->orWhereHas('adquirente', function ($q) {
                $q->where('nombre', 'like', '%' . $this->query . '%')
                  ->orWhere('apellido', 'like', '%' . $this->query . '%');
              });
          });
          break;
      }
    }


    if (!empty($this->estadoFilter)) {
      $ordenes->where('estado', $this->estadoFilter);
    }

    // 🔽 Ordenamiento (agrega tu lógica si quieres sortField/sortDirection)
    $ordenes = $ordenes->orderBy('id', 'desc')->paginate(15);

    return view('livewire.admin.ordenes.index', compact('ordenes'));
  }
}
