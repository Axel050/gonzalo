<?php

namespace App\Livewire\Admin\Comitentes;

use App\Models\Comitente;
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
  public $ids, $alias;

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



  #[On(['comitenteCreated', 'comitenteUpdated', 'comitenteDeleted', 'loteCreated', 'autorizadoCreated'])]
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
          $comitentes = Comitente::where(function ($q) {
            $search = trim($this->query);
            $words = array_filter(explode(' ', $search)); // Separa palabras y elimina vacías

            $q->orWhere('id', 'like', "%$search%")
              ->orWhere('nombre', 'like', "%$search%")
              ->orWhere('apellido', 'like', "%$search%")
              ->orWhere('telefono', 'like', "%$search%")
              ->orWhere('mail', 'like', "%$search%")
              ->orWhere('CUIT', 'like', "%$search%")
              ->orWhereHas('alias', function ($query) use ($search) {
                $query->where('nombre', 'like', "%$search%");
              });

            // Si hay al menos dos palabras, buscar combinación nombre + apellido
            if (count($words) >= 2) {
              $nombre = $words[0];
              $apellido = $words[1];

              $q->orWhere(function ($subq) use ($nombre, $apellido) {
                $subq->where('nombre', 'like', "%$nombre%")
                  ->where('apellido', 'like', "%$apellido%");
              });
            }
          });
          break;

          // 

          // 
      }
      $comitentes = $comitentes->orderBy("id", "desc")->paginate(15);
    } else {
      $comitentes = Comitente::orderBy("id", "desc")->paginate(15);
    }




    return view('livewire.admin.comitentes.index', compact('comitentes'));
  }
}
