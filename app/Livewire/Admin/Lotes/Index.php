<?php

namespace App\Livewire\Admin\Lotes;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Lote;
use App\Models\Subasta;
use App\Models\TiposBien;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
  use WithPagination;

  public $tipoSeleccionado = null;
  public $caracteristicaSeleccionada = null;
  public $caracteristicasDisponibles = [];

  public $tipos = [];




  public $estados = [];
  public $query, $nombre, $id;
  public $method = "";
  public $modal_foto = "";
  public $searchType = "todos";
  public $inputType = "search";
  public $estadoFilter;
  public $destacados;

  #[Url]
  public $ids;

  #[Url]
  public $fromCont;



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




    if ($this->fromCont) {
      $lote = Lote::find($this->fromCont);

      if ($lote) {
        $this->id = $this->fromCont;
        return $this->method = "update";
      }
    }




    if ($this->ids) {
      $parts = explode('-', $this->ids);


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

  #[On('loteContrato')]
  public function cerrar()
  {
    $this->method = "";
  }




  public function updatingQuery()
  {
    $this->resetPage();
  }

  public function updatedSearchType()
  {

    if ($this->searchType == 'tipo') {
      $this->tipos  = TiposBien::orderBy('nombre')->get();
      $this->query = "";
    }

    if ($this->searchType !== 'tipo') {
      $this->reset(
        'tipoSeleccionado',
        'caracteristicaSeleccionada',
        'caracteristicasDisponibles'
      );
    }
  }





  public function updatedTipoSeleccionado()
  {
    // info("adade");
    $this->reset('caracteristicaSeleccionada');
    // info(["tipo 1111" => $this->tipoSeleccionado]);

    if (!$this->tipoSeleccionado) {
      $this->caracteristicasDisponibles = [];
      return;
    }
    // info(["tipo solo" => $this->tipoSeleccionado]);


    $this->caracteristicasDisponibles = TiposBien::find($this->tipoSeleccionado)->caracteristicas()->orderBy('nombre')->get();
    // $this->caracteristicasDisponibles = TiposBien::find(2)
    // ?->caracteristicas
    // ?? []
    // ;

    // info(["tipoaaaaa" => $this->caracteristicasDisponibles]);


    // info(["tipo" => $this->tipoSeleccionado, "caracteristicas" => $this->caracteristicasDisponibles]);
    $this->resetPage();
  }



  public function render()
  {
    $lotes = Lote::query();


    // if ($this->query && $this->searchType == 'tipo' && $this->caracteristicaSeleccionada) {
    if ($this->query || $this->searchType == 'tipo') {


      $searchTerm = '%' . $this->query . '%'; // Define el término de búsqueda con wildcards una vez


      switch ($this->searchType) {
        case 'id':
          // $lotes->where('id', 'like', '%' . $this->query . '%');
          $lotes->where('id',  $this->query);
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

          // Solo tipo seleccionado → filtra por tipo_bien

          if ($this->tipoSeleccionado && !$this->caracteristicaSeleccionada) {
            $lotes->where('tipo_bien_id', $this->tipoSeleccionado);
          }

          // Tipo + característica → buscar SOLO en esa característica
          if (
            $this->tipoSeleccionado &&
            $this->caracteristicaSeleccionada &&
            $this->query
          ) {
            $searchTerm = '%' . $this->query . '%';

            $lotes->where('tipo_bien_id', $this->tipoSeleccionado)
              ->whereHas('valoresCaracteristicas', function ($q) use ($searchTerm) {
                $q->where('caracteristica_id', $this->caracteristicaSeleccionada)
                  ->where('valor', 'like', $searchTerm);
              });
          }

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

    if ($this->destacados) {
      $lotes->where('destacado', true);
    }

    // Si no hay filtros, mostrar todos los lotes
    $lotes = $lotes->orderBy('id', 'desc')->paginate(15);
    return view('livewire.admin.lotes.index', compact('lotes'));
  }
}
