<?php

namespace App\Livewire\Admin\Lotes;

use App\Enums\LotesEstados;
use App\Models\Comitente;
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
  public $estados = [];
  public $estadoFilter;

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

    if ($method == "history") {
      $this->method = $method;
      $this->id = $id;
    }
  }

  #[On(['closeModalToIndex'])]
  public function closeHistoryToIndex()
  {
    $this->method = "";
  }


  #[On(['loteCreated', 'loteUpdated', 'loteDeleted', 'loteCreated'])]
  public function mount()
  {

    // $s = Subasta::find(6);
    // info([
    //   // "www" => $s->uniqueLotes()->count()
    //   "www" => $s->contarLotes()
    //   // "www" => $s->uniqueLotes()
    // ]);
    // dd("MEJOREAR EL SEEDERR  PARA LOTES Y CONTRATO LOTES");
    // $this->estados = LotesEstados::all();

    $this->estados = array_map(function ($estado) {
      return [
        'value' => $estado,
        'label' => LotesEstados::getLabel($estado),
      ];
    }, LotesEstados::all());
    // info($this->estados);

    $exists = false;

    if ($this->ids) {
      $parts = explode('-', $this->ids);

      info($parts);

      if ($parts[0] == "comitente") {
        $exists = Comitente::where('id', $parts[1])->first();
        $this->query = $exists->nombre . ' ' . $exists->apellido;
        // $this->query = $exists->nombre;

        info([
          "existes" => $exists,
          "nomrne" => $exists->nombre
        ]);
      }

      if ($parts[0] == "subasta") {
        $exists = Subasta::where('id', $parts[1])->exists();
        $this->query = $parts[1];
      }

      if ($exists) {
        $this->searchType = $parts[0];
      } else {
        $this->searchType = "todos";
        $this->query = "";
      }
    }

    $this->method = "";
    $this->resetPage();
  }

  public function render2()
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
        case 'encargado':
          $lotes = Lote::whereHas('tipo.encargado', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%')
              ->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
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
            ->orWhereHas('tipo.encargado', function ($query) {
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


  public function render()
  {
    $lotes = Lote::query();


    if ($this->query) {


      $searchTerm = '%' . $this->query . '%'; // Define el término de búsqueda con wildcards una vez


      switch ($this->searchType) {
        case 'id':
          $lotes->where('id', 'like', '%' . $this->query . '%');
          break;
        case 'comitente':
          // $lotes->whereHas('comitente', function ($query) {
          //   $query->where('nombre', 'like', '%' . $this->query . '%')
          //     ->orWhere('apellido', 'like', '%' . $this->query . '%');
          // });

          $lotes->whereHas('comitente', function ($query) use ($searchTerm) {
            // Agrupa las condiciones OR para el comitente
            $query->where(function ($q) use ($searchTerm) {
              $q->where('nombre', 'like', $searchTerm)
                ->orWhere('apellido', 'like', $searchTerm)
                // Buscar en el nombre completo concatenado (nombre apellido)
                ->orWhereRaw("CONCAT_WS(' ', nombre, apellido) LIKE ?", [$searchTerm])
                // Opcional: Buscar también en (apellido nombre)
                ->orWhereRaw("CONCAT_WS(' ', apellido, nombre) LIKE ?", [$searchTerm]);
            });
          });
          break;
        case 'alias':
          $lotes->whereHas('comitente.alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'tipo':
          $lotes->whereHas('tipo', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'subasta':
          $lotes->whereHas('ultimoContrato', function ($query) {
            $query->where('subasta_id', 'like', '%' . $this->query . '%');
          });
          break;
        case 'contrato':
          $lotes->where('ultimo_contrato', 'like', '%' . $this->query . '%');
          break;

        case 'titulo':
          $lotes->where('titulo', 'like', '%' . $this->query . '%');
          break;
        case 'encargado':
          $lotes->whereHas('tipo.encargado', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%')
              ->orWhere('apellido', 'like', '%' . $this->query . '%');
          });
          break;
        case 'todos':
          // $lotes->where(function ($query) {
          //   $query->where('id', 'like', '%' . $this->query . '%')
          //     ->orWhereHas('comitente', function ($q) {
          //       $q->where('nombre', 'like', '%' . $this->query . '%')
          //         ->orWhere('apellido', 'like', '%' . $this->query . '%');
          //     })
          //     ->orWhereHas('comitente.alias', function ($q) {
          //       $q->where('nombre', 'like', '%' . $this->query . '%');
          //     })
          //     ->orWhereHas('tipo', function ($q) {
          //       $q->where('nombre', 'like', '%' . $this->query . '%');
          //     })
          //     ->orWhereHas('tipo.encargado', function ($q) {
          //       $q->where('nombre', 'like', '%' . $this->query . '%')
          //         ->orWhere('apellido', 'like', '%' . $this->query . '%');
          //     })
          //     ->orWhereHas('ultimoContrato', function ($q) {
          //       $q->where('subasta_id', 'like', '%' . $this->query . '%');
          //     })
          //     // ->orWhere('estado', 'like', '%' . $this->query . '%')
          //     ->orWhere('ultimo_contrato', 'like', '%' . $this->query . '%')
          //     ->orWhere('titulo', 'like', '%' . $this->query . '%');
          // });
          $lotes->where(function ($query) use ($searchTerm) {
            $query->where('id', 'like', $searchTerm)
              ->orWhereHas('comitente', function ($q) use ($searchTerm) {
                $q->where(function ($sq) use ($searchTerm) { // sq for subQuery
                  $sq->where('nombre', 'like', $searchTerm)
                    ->orWhere('apellido', 'like', $searchTerm)
                    ->orWhereRaw("CONCAT_WS(' ', nombre, apellido) LIKE ?", [$searchTerm])
                    ->orWhereRaw("CONCAT_WS(' ', apellido, nombre) LIKE ?", [$searchTerm]);
                });
              })
              ->orWhereHas('comitente.alias', function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', $searchTerm);
              })
              ->orWhereHas('tipo', function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', $searchTerm);
              })
              ->orWhereHas('tipo.encargado', function ($q) use ($searchTerm) {
                $q->where(function ($sq) use ($searchTerm) {
                  $sq->where('nombre', 'like', $searchTerm)
                    ->orWhere('apellido', 'like', $searchTerm)
                    ->orWhereRaw("CONCAT_WS(' ', nombre, apellido) LIKE ?", [$searchTerm])
                    ->orWhereRaw("CONCAT_WS(' ', apellido, nombre) LIKE ?", [$searchTerm]);
                });
              })
              ->orWhereHas('ultimoContrato', function ($q) use ($searchTerm) {
                $q->where('subasta_id', 'like', $searchTerm);
              })
              // ->orWhere('estado', 'like', $searchTerm) // Comentado como en tu original
              ->orWhere('ultimo_contrato', 'like', $searchTerm)
              ->orWhere('titulo', 'like', $searchTerm);
          });
          break;
          break;
      }
    }

    // Filtro por estado
    if ($this->estadoFilter) {
      $lotes->where('estado', $this->estadoFilter);
    }

    // Si no hay filtros, mostrar todos los lotes
    $lotes = $lotes->orderBy('id', 'desc')->paginate(10);
    return view('livewire.admin.lotes.index', compact('lotes'));
  }
}
