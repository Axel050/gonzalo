<?php

namespace App\Livewire\Admin\Personal\Usuarios;

use App\Models\Personal;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
  use WithPagination;

  #[Url]
  public $ids;

  public $query, $nombre, $id;
  public $method = "";
  public $searchType = "todos";
  public $inputType = "search";

  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view") {
      $cond = Personal::find($id);
      if (!$cond) {
        $this->dispatch('personalNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['personalCreated', 'personalUpdated', 'personalDeleted'])]
  public function mount()
  {
    if ($this->ids) {
      $this->query = $this->ids;
      $this->searchType = "id";
    }

    $this->method = "";
    $this->resetPage();
  }

  public function render()
  {


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $personal = Personal::where("id", "like", '%' . $this->query . '%');
          break;
        case 'nombre':
          $personal = Personal::where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'apellido':
          $personal = Personal::where("apellido", "like", '%' . $this->query . '%');
          break;
        case 'alias':
          $personal = Personal::where("alias", "like", '%' . $this->query . '%');
          break;
        case 'telefono':
          $personal = Personal::where("telefono", "like", '%' . $this->query . '%');
          break;
        case 'email':
          $personal = Personal::whereHas('user', function ($query) {
            $query->where('email', 'like', '%' . $this->query . '%');
          });
          break;
        case 'rol':
          $personal = Personal::whereHas('role', function ($query) {
            $query->where('name', 'like', '%' . $this->query . '%');
          });
          break;
        case 'todos':
          $personal = Personal::where("id", "like", '%' . $this->query . '%')
            ->orWhere("nombre", "like", '%' . $this->query . '%')
            ->orWhere("apellido", "like", '%' . $this->query . '%')
            ->orWhere("telefono", "like", '%' . $this->query . '%')
            ->orWhere("alias", "like", '%' . $this->query . '%')
            ->orWhereHas('user', function ($query) {
              $query->where('email', 'like', '%' . $this->query . '%');
            })
            ->orWhereHas('role', function ($query) {
              $query->where('name', 'like', '%' . $this->query . '%');
            });
          break;
      }
      $personal = $personal->orderBy("id", "desc")->paginate(10);
    } else {
      $personal = Personal::orderBy("id", "desc")->paginate(10);
    }



    return view('livewire.admin.personal.usuarios.index', compact("personal"));
  }
}
