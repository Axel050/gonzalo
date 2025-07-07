<?php

namespace App\Livewire\Admin\Contratos;


use App\Models\Contrato;
use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
  use WithPagination;

  public $new;
  public $query, $nombre, $id;
  public $method;
  public $searchType = "todos";
  public $inputType = "search";

  #[Url]
  public $ids;

  #[On(['lotes'])]
  public function openLotes($id = false)
  {
    $this->new = 1;
    $this->id = $id;
    $this->method = "lotes";
  }

  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view"   || $method == "lotes") {
      $this->new = false;
      $cond = Contrato::find($id);
      if (!$cond) {
        $this->dispatch('contratoNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }

    if ($method == "save") {
      $this->method = $method;
    }
  }


  #[On(['contratoCreated', 'contratoUpdated', 'contratoDeleted', 'loteCreated'])]
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
          $contratos = Contrato::where("id", "like", '%' . $this->query . '%');
          break;
        case 'comitente':
          $contratos = Contrato::whereHas('comitente', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
            $query->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
        case 'alias':
          $contratos = Contrato::whereHas('comitente.alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'fecha':
          $contratos = Contrato::where("fecha_firma", "like", '%' . $this->query . '%');
          break;
        case 'subasta':
          $contratos = Contrato::where("subasta_id", "like", '%' . $this->query . '%');
          break;

        case 'todos':
          $contratos = Contrato::where("id", "like", '%' . $this->query . '%')
            ->orWhereHas('comitente', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
              $query->orWhere('apellido', 'like', '%' . $this->query . '%');
            })
            ->orWhereHas('comitente.alias', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
            })
            ->orWhere("subasta_id", "like", '%' . $this->query . '%')
            ->orWhere("fecha_firma", "like", '%' . $this->query . '%');
          break;
      }
      $contratos = $contratos->orderBy("id", "desc")->paginate(15);
    } else {
      $contratos = Contrato::orderBy("id", "desc")->paginate(15);
    }


    return view('livewire.admin.contratos.index', compact("contratos"));
  }
}
