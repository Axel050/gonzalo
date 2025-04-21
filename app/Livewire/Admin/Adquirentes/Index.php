<?php

namespace App\Livewire\Admin\Adquirentes;

use App\Models\Adquirente;
use App\Models\Comitente;
use App\Models\Subasta;
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


  public function updatedSearchType()
  {
    if ($this->searchType == "inicio"   || $this->searchType == "fin") {
      $this->inputType = "date";
    } else {
      $this->inputType = "search";
    }
    // else {
    //   $
    // }


  }


  #[On(['autorizado'])]
  public function openAut($id = false)
  {
    $this->id = $id;
    $this->method = "autorizados";
  }

  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view" || $method == "autorizados") {
      $adquirente = Adquirente::find($id);


      if (!$adquirente) {
        $this->dispatch('paisNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['adquirenteCreated', 'adquirenteUpdated', 'adquirenteDeleted', 'autorizadoCreated'])]
  public function mount()
  {
    $this->method = "";
    $this->resetPage();
  }

  public function render()
  {

    // AHORA MAIL ESTA EN USERS   
    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $adquirentes = Adquirente::where("id", "like", '%' . $this->query . '%');
          break;
        case 'nombre':
          $adquirentes = Adquirente::where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'apellido':
          $adquirentes = Adquirente::where("apellido", "like", '%' . $this->query . '%');
          break;
        case 'telefono':
          $adquirentes = Adquirente::where("telefono", "like", '%' . $this->query . '%');
          break;
        case 'CUIT':
          $adquirentes = Adquirente::where("CUIT", "like", '%' . $this->query . '%');
          break;
        case 'mail':
          $adquirentes = Adquirente::join('users', 'adquirentes.user_id', '=', 'users.id')
            ->where("users.email", "like", '%' . $this->query . '%');
          break;
        case 'alias':
          $adquirentes = Adquirente::where("alias", "like", '%' . $this->query . '%');
          break;
        case 'todos':
          $adquirentes = Adquirente::join('users', 'adquirentes.user_id', '=', 'users.id')
            ->where(function ($query) {
              $query->where("adquirentes.id", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.nombre", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.apellido", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.telefono", "like", '%' . $this->query . '%')
                // ->orWhere("email", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.CUIT", "like", '%' . $this->query . '%')
                ->orWhere("alias", "like", '%' . $this->query . '%')
                ->orWhere("users.email", "like", '%' . $this->query . '%');
            });
          break;
      }

      $adquirentes = $adquirentes->orderBy("adquirentes.id", "desc")->paginate(10);
      // $adquirentes = $adquirentes->paginate(7);
    } else {
      $adquirentes = Adquirente::orderBy("adquirentes.id", "desc")->paginate(10);
    }




    return view('livewire.admin.adquirentes.index', compact("adquirentes"));
  }
}
