<?php

namespace App\Livewire\Admin\Facturas;

use App\Models\Factura;
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
    $facturas = Factura::query();

    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $facturas->where('id', 'like', '%' . $this->query . '%');
          break;
        case 'adquirente':
          $facturas->whereHas('adquirente', function ($q) {
            $q->where('nombre', 'like', '%' . $this->query . '%')
              ->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
        case 'orden':
          $facturas->where('orden_id', 'like', '%' . $this->query . '%');
          break;
        case 'todos':
          $facturas->where(function ($q) {
            $q->where('id', 'like', '%' . $this->query . '%')
              ->orWhere('orden_id', 'like', '%' . $this->query . '%')
              ->orWhere('nombre', 'like', '%' . $this->query . '%')
              ->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
      }
    }

    $facturas = $facturas->orderBy('id', 'desc')->paginate(15);

    return view('livewire.admin.facturas.index', compact('facturas'));
  }
}
