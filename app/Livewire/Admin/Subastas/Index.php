<?php

namespace App\Livewire\Admin\Subastas;

use App\Models\Subasta;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

  use WithPagination;

  #[Url]
  public $ids;

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



  public function option($method, $id = false)
  {
    if ($method == "delete" || $method == "update" || $method == "view" || $method == "pujas") {
      $sub = Subasta::find($id);


      if (!$sub) {
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


  #[On(['subastaCreated', 'subastaUpdated', 'subastaDeleted'])]
  public function mount()
  {
    if ($this->ids) {
      $this->query = $this->ids;
      $this->searchType = "id";
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

  public function rende2r()
  {


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $subastas = Subasta::where("id", "like", '%' . $this->query . '%');
          break;
        case 'titulo':
          $subastas = Subasta::where("titulo", "like", '%' . $this->query . '%');
          break;
        case 'inicio':
          $subastas = Subasta::whereDate('fecha_inicio', $this->query);
          break;
        case 'fin':
          $subastas = Subasta::whereDate('fecha_fin', $this->query);
          break;
        case 'todos':
          $subastas = Subasta::where("id", "like", '%' . $this->query . '%')
            ->orWhere(".titulo", "like", '%' . $this->query . '%')
            ->orWhere("fecha_inicio", "like", '%' . $this->query . '%')
            ->orWhere("fecha_fin", "like", '%' . $this->query . '%');
          break;
      }
      $subastas = $subastas->orderBy("id", "desc")->paginate(15);
    } else {
      $subastas = Subasta::orderBy("id", "desc")->paginate(15);
    }



    return view('livewire.admin.subastas.index', compact('subastas'));
  }
  public function render()
  {
    $subastasQuery = Subasta::query()->withCount('pujas');

    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $subastasQuery->where('id', 'like', '%' . $this->query . '%');
          break;

        case 'titulo':
          $subastasQuery->where('titulo', 'like', '%' . $this->query . '%');
          break;

        case 'inicio':
          $subastasQuery->whereDate('fecha_inicio', $this->query);
          break;

        case 'fin':
          $subastasQuery->whereDate('fecha_fin', $this->query);
          break;

        case 'todos':
          $subastasQuery
            ->where('id', 'like', '%' . $this->query . '%')
            ->orWhere('titulo', 'like', '%' . $this->query . '%')
            ->orWhereDate('fecha_inicio', $this->query)
            ->orWhereDate('fecha_fin', $this->query);
          break;
      }
    }

    $subastas = $subastasQuery
      ->orderBy('id', 'desc')
      ->paginate(15);

    return view('livewire.admin.subastas.index', compact('subastas'));
  }
}
