<?php

namespace App\Livewire\Admin\Comitentes;

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
      $comitente = Comitente::find($id);
      // Log::alert("uppdppdpd");

      if (!$comitente) {
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


  #[On(['comitenteCreated', 'comitenteUpdated', 'comitenteDeleted', 'autorizadoCreated'])]
  public function mount()
  {
    $this->method = "";
    $this->resetPage();
  }

  public function render()
  {


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $comitentes = Comitente::where("id", "like", '%' . $this->query . '%');
          break;
        case 'nombre':
          $comitentes = Comitente::where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'apellido':
          $comitentes = Comitente::where("apellido", "like", '%' . $this->query . '%');
          break;
        case 'telefono':
          $comitentes = Comitente::where("telefono", "like", '%' . $this->query . '%');
          break;
        case 'CUIT':
          $comitentes = Comitente::where("CUIT", "like", '%' . $this->query . '%');
          break;
        case 'mail':
          $comitentes = Comitente::where("mail", "like", '%' . $this->query . '%');
          break;
        case 'alias':
          $comitentes = Comitente::whereHas('alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'todos':
          $comitentes = Comitente::where("id", "like", '%' . $this->query . '%')
            ->orWhere("nombre", "like", '%' . $this->query . '%')
            ->orWhere("apellido", "like", '%' . $this->query . '%')
            ->orWhere("telefono", "like", '%' . $this->query . '%')
            ->orWhere("mail", "like", '%' . $this->query . '%')
            ->orWhere("CUIT", "like", '%' . $this->query . '%')
            ->orWhereHas('alias', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
            });
          break;
      }
      $comitentes = $comitentes->orderBy("id", "desc")->paginate(7);
    } else {
      $comitentes = Comitente::orderBy("id", "desc")->paginate(7);
    }




    return view('livewire.admin.comitentes.index', compact('comitentes'));
  }
}
