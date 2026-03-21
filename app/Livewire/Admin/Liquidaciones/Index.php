<?php

namespace App\Livewire\Admin\Liquidaciones;

use App\Models\Liquidacion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
  use WithPagination;

  public $query;
  public $searchType = 'todos';
  public $method = '';
  public $id;

  public function updatingQuery()
  {
    $this->resetPage();
  }

  public function option($method, $id = false)
  {
    $this->method = $method;
    $this->id = $id;
  }

  #[On(['facturaCreated', 'facturasGenerated'])]
  public function close()
  {
    $this->method = '';
    $this->resetPage();
  }

  public function render()
  {
    $liquidaciones = Liquidacion::query();

    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $liquidaciones->where('id', 'like', '%' . $this->query . '%');
          break;
        case 'adquirente':
          $liquidaciones->whereHas('adquirente', function ($q) {
            $q->where('nombre', 'like', '%' . $this->query . '%')
              ->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
        case 'orden':
          $liquidaciones->where('orden_id', 'like', '%' . $this->query . '%');
          break;
        case 'todos':
          $liquidaciones->where(function ($q) {
            $q->where('id', 'like', '%' . $this->query . '%')
              ->orWhere('orden_id', 'like', '%' . $this->query . '%')
              ->orWhere('nombre', 'like', '%' . $this->query . '%')
              ->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
      }
    }

    $liquidaciones = $liquidaciones->orderBy('id', 'desc')->paginate(15);

    return view('livewire.admin.liquidaciones.index', compact('liquidaciones'));
  }
}
