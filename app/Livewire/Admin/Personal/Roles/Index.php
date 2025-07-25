<?php

namespace App\Livewire\Admin\Personal\Roles;

use App\Models\Personal;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component
{
  use WithPagination;

  public $query, $nombre, $id;
  public $method = "";
  public $searchType = "todos";
  public $inputType = "search";

  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view" || $method == "permisos") {
      $cond = Role::find($id);
      if (!$cond) {
        $this->dispatch('rolNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['rolCreated', 'rolUpdated', 'rolDeleted', 'permisosAdded'])]
  public function mount()
  {
    $this->method = "";
    $this->resetPage();
  }

  public function render()
  {


    $rolesQuery = Role::where('name', '!=', 'adquirente');

    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $rolesQuery->where('id', 'like', '%' . $this->query . '%');
          break;

        case 'name':
          $rolesQuery->where('name', 'like', '%' . $this->query . '%');
          break;

        case 'description':
          $rolesQuery->where('description', 'like', '%' . $this->query . '%');
          break;

        case 'todos':
          $rolesQuery->where(function ($q) {
            $q->where('id', 'like', '%' . $this->query . '%')
              ->orWhere('name', 'like', '%' . $this->query . '%')
              ->orWhere('description', 'like', '%' . $this->query . '%');
          });
          break;
      }
    }

    $roles = $rolesQuery->orderBy('id', 'desc')->paginate(10);



    return view('livewire.admin.personal.roles.index', compact("roles"));
  }
}
