<?php

namespace App\Livewire\Admin\Lotes;

use App\Models\Lote;
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
  public $modal_foto = "";
  public $searchType = "todos";
  public $inputType = "search";

  #[Url]
  public $ids;

  #[On(['lotes'])]
  public function openLotes($id = false)
  {
    $this->id = $id;
    $this->method = "lotes";
  }

  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view"   || $method == "lotes") {
      $cond = Lote::find($id);
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

  public function render()
  {


    if ($this->query) {


      switch ($this->searchType) {
        case 'id':
          $lotes = Lote::where("id", "like", '%' . $this->query . '%');
          break;
        case 'comitente':
          $lotes = Lote::whereHas('comitente', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
            $query->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
        case 'alias':
          $lotes = Lote::whereHas('comitente.alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'tipo':
          $lotes = Lote::whereHas('tipo', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'subasta':
          $lotes = Lote::whereHas('ultimoContrato', function ($query) {
            $query->where('subasta_id', 'like', '%' . $this->query . '%');
          });
          break;
        case 'contrato':
          $lotes = Lote::where("ultimo_contrato", "like", '%' . $this->query . '%');
          break;
        case 'estado':
          $lotes = Lote::where("estado", "like", '%' . $this->query . '%');
          break;
        case 'titulo':
          $lotes = Lote::where("titulo", "like", '%' . $this->query . '%');
          break;

        case 'todos':
          $lotes = Lote::where("id", "like", '%' . $this->query . '%')
            ->orWhereHas('comitente', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
              $query->orWhere('apellido', 'like', '%' . $this->query . '%');
            })
            ->orWhereHas('comitente.alias', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
            })
            ->orWhereHas('tipo', function ($query) {
              $query->where('nombre', 'like', '%' . $this->query . '%');
            })
            ->orWhereHas('ultimoContrato', function ($query) {
              $query->where('subasta_id', 'like', '%' . $this->query . '%');
            })
            ->orWhere("estado", "like", '%' . $this->query . '%')
            ->orWhere("ultimo_contrato", "like", '%' . $this->query . '%')
            ->orWhere("titulo", "like", '%' . $this->query . '%');

          break;
      }
      $lotes = $lotes->orderBy("id", "desc")->paginate(10);
    } else {
      $lotes = Lote::orderBy("id", "desc")->paginate(10);
    }


    return view('livewire.admin.lotes.index', compact("lotes"));
  }
}
