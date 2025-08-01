<?php

namespace App\Livewire\Admin\Auditorias;

use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;

class Index extends Component
{
  use WithPagination;

  public $audits;

  public $query, $nombre, $id;
  public $method = "";
  public $searchType = "todos";
  public $inputType = "search";
  public $eventFilter = "";



  public function option($method, $id = false)
  {

    if ($method == "delete"  || $method == "view") {
      $auditoria = Audit::find($id);


      if (!$auditoria) {
        $this->dispatch('auditoriaNotExits');
      } else {
        $this->method = $method;
        $this->id = $id;
      }
    }
  }


  #[On(['auditoriaDeleted'])]
  public function mount()
  {

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


    $auditorias = Audit::query();


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $auditorias->where("id", "like", '%' . $this->query . '%');
          break;
        case 'tipo':
          $auditorias->where("auditable_type", "like", '%' . $this->query . '%');
          break;
        case 'tipo_id':
          $auditorias->where("auditable_id", "like", '%' . $this->query . '%');
          break;
        case 'fecha':
          $auditorias->where("created_at", "like", '%' . $this->query . '%');
          break;
        case 'usuario':
          $auditorias->join('users', 'audits.user_id', '=', 'users.id')
            ->leftJoin('personals', 'users.id', '=', 'personals.user_id')
            ->where(function ($q) {
              $q->where('users.name', 'like', '%' . $this->query . '%')
                ->orWhere('personals.apellido', 'like', '%' . $this->query . '%')
                ->orWhereRaw("CONCAT(users.name, ' ', personals.apellido) LIKE ?", ['%' . $this->query . '%'])
                ->orWhereRaw("CONCAT(personals.apellido, ' ', users.name) LIKE ?", ['%' . $this->query . '%']);
            })
            ->select('audits.*');
          break;


        case 'todos':
          $auditorias->join('users', 'audits.user_id', '=', 'users.id')
            ->leftJoin('personals', 'users.id', '=', 'personals.user_id')
            ->where(function ($q) {
              $q->where("audits.id", "like", '%' . $this->query . '%')
                ->orWhere("audits.auditable_type", "like", '%' . $this->query . '%')
                ->orWhere("audits.auditable_id", "like", '%' . $this->query . '%')
                ->orWhere("audits.created_at", "like", '%' . $this->query . '%')
                ->orWhere("users.name", "like", '%' . $this->query . '%')
                ->orWhere("personals.apellido", "like", '%' . $this->query . '%')
                ->orWhereRaw("CONCAT(users.name, ' ', personals.apellido) LIKE ?", ['%' . $this->query . '%'])
                ->orWhereRaw("CONCAT(personals.apellido, ' ', users.name) LIKE ?", ['%' . $this->query . '%']);
            })
            ->select('audits.*');
          break;
      }
    }


    if (!empty($this->eventFilter)) {
      $auditorias->where("event", "like", '%' . $this->eventFilter . '%');
    }

    $auditorias = $auditorias->orderBy("id", "desc")->paginate(15);


    return view('livewire.admin.auditorias.index', compact("auditorias"));
  }
}
