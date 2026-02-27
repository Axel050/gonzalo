<?php

namespace App\Livewire\Admin\Adquirentes;

use App\Models\Adquirente;
use App\Models\Comitente;
use App\Models\Subasta;
use App\Services\BrevoService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Symfony\Polyfill\Intl\Idn\Info;

class Index extends Component
{


  use WithPagination;

  #[Url]
  public $ids, $alias;

  public $query, $nombre, $id;
  public $sinAgendar = false;

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


  public function deleteToBrevo($id)
  {

    $adquirente = Adquirente::find($id);
    if ($adquirente->agendado && $adquirente->user?->email) {
      $brevoService = new BrevoService();
      $result = $brevoService->deleteContact($adquirente->user->email);
      // $result = $brevoService->deleteContact("ww@adad.com");

      if ($result['success']) {
        $this->dispatch('contactDeleted');
        $adquirente->update(['agendado' => false]);
      } else {
        info("Error al eliminar contacto de Brevo: " . $result['message']);
        $this->dispatch('contactErrorDeleted');
      }
    }
  }




  public function syncToBrevo($id)
  {

    $adquirente = Adquirente::find($id);

    if (!$adquirente || !$adquirente->user?->email) {
      $this->dispatch('error', 'El adquirente no tiene un email válido.');
      return;
    }

    $brevoService = new BrevoService();
    $result = $brevoService->createContact(
      $adquirente->user->email,
      [
        'NOMBRE' => $adquirente->nombre,
        'APELLIDOS' => $adquirente->apellido,
        // 'SMS' => $adquirente->telefono ?  "54" . preg_replace('/\D/', '', $adquirente->telefono) : null,
      ],
      [config('services.brevo.adquirentes_list_id')] // ID de la lista en Brevo
      // [7] 
      // [5]
    );

    // info(["id" => config('services.brevo.adquirentes_list_id')]);

    if ($result['success']) {
      $adquirente->update(['agendado' => true]);
      $this->dispatch('contactCreated');
      $this->dispatch('success', 'Contacto sincronizado con Brevo.');
    } else {
      info("No resulta", ["result" => $result]);
      $this->dispatch('contactErrorCreated', 'Error al sincronizar con Brevo.');
    }
  }




  public function render()
  {


    $adquirentes = Adquirente::query();


    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $adquirentes->where("id", $this->query);
          break;
        case 'nombre':
          $adquirentes->where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'apellido':
          $adquirentes->where("apellido", "like", '%' . $this->query . '%');
          break;
        case 'telefono':
          $adquirentes->where("telefono", "like", '%' . $this->query . '%');
          break;
        case 'CUIT':
          $adquirentes->where("CUIT", "like", '%' . $this->query . '%');
          break;
        case 'mail':
          $adquirentes->join('users', 'adquirentes.user_id', '=', 'users.id')
            ->where("users.email", "like", '%' . $this->query . '%');
          break;
        case 'alias':
          $adquirentes->whereHas('alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'todos':


          $terms = preg_split('/\s+/', trim($this->query));

          $adquirentes->join('users', 'adquirentes.user_id', '=', 'users.id')
            ->select('adquirentes.*')
            ->where(function ($query) use ($terms) {

              $search = '%' . $this->query . '%';

              $query->where("adquirentes.id", "like", $search)
                ->orWhere("adquirentes.telefono", "like", $search)
                ->orWhere("adquirentes.CUIT", "like", $search)
                ->orWhere("users.email", "like", $search)

                // 🔥 NOMBRE + APELLIDO POR PALABRAS
                ->orWhere(function ($q) use ($terms) {
                  foreach ($terms as $term) {
                    $like = '%' . $term . '%';

                    $q->where(function ($qq) use ($like) {
                      $qq->where('adquirentes.nombre', 'like', $like)
                        ->orWhere('adquirentes.apellido', 'like', $like);
                    });
                  }
                })

                ->orWhereHas('alias', function ($q) use ($search) {
                  $q->where('nombre', 'like', $search);
                });
            });
          break;
      }
    }



    if ($this->sinAgendar) {
      $adquirentes->where("agendado", false);
    }

    $adquirentes->orderBy("adquirentes.id", "desc")->paginate(15);



    $adquirentes = $adquirentes->orderBy("adquirentes.id", "desc")->paginate(15);

    return view('livewire.admin.adquirentes.index', compact("adquirentes"));
  }
}
