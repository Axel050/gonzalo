<?php

namespace App\Livewire\Admin\Adquirentes;

use App\Models\Adquirente;
use App\Models\Comitente;
use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{


  use WithPagination;

  #[Url]
  public $ids, $alias;

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
        $this->dispatch('adquirenteNotExits');
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

    if ($this->ids) {
      $this->query = $this->ids;
      $this->searchType = "id";
    }
    if ($this->alias) {
      $this->query = $this->alias;
      $this->searchType = "alias";
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
          $adquirentes = Adquirente::whereHas('alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'todos':
          // $adquirentes = Adquirente::join('users', 'adquirentes.user_id', '=', 'users.id')
          //   ->where(function ($query) {
          //     $query->where("adquirentes.id", "like", '%' . $this->query . '%')
          //       ->orWhere("adquirentes.nombre", "like", '%' . $this->query . '%')
          //       ->orWhere("adquirentes.apellido", "like", '%' . $this->query . '%')
          //       ->orWhere("adquirentes.telefono", "like", '%' . $this->query . '%')
          //       ->orWhere("adquirentes.CUIT", "like", '%' . $this->query . '%')
          //       ->orWhere("users.email", "like", '%' . $this->query . '%')
          //       ->orWhereHas('alias', function ($query) {
          //         $query->where('nombre', 'like', '%' . $this->query . '%');
          //       });
          //   });
          $adquirentes = Adquirente::join('users', 'adquirentes.user_id', '=', 'users.id')
            ->select('adquirentes.*')  // Add this to avoid ID conflict
            ->where(function ($query) {
              $query->where("adquirentes.id", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.nombre", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.apellido", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.telefono", "like", '%' . $this->query . '%')
                ->orWhere("adquirentes.CUIT", "like", '%' . $this->query . '%')
                ->orWhere("users.email", "like", '%' . $this->query . '%')
                ->orWhereHas('alias', function ($q) {  // Note: Renamed to $q to avoid shadowing
                  $q->where('nombre', 'like', '%' . $this->query . '%');
                });
            });
          break;
      }

      $adquirentes = $adquirentes->orderBy("adquirentes.id", "desc")->paginate(15);
      // $adquirentes = $adquirentes->paginate(7);
    } else {
      $adquirentes = Adquirente::orderBy("adquirentes.id", "desc")->paginate(15);
    }




    return view('livewire.admin.adquirentes.index', compact("adquirentes"));
  }
}
