<?php

namespace App\Livewire\Admin\Comitentes;

use App\Models\Comitente;
use App\Services\BrevoService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\Attributes\Url;

class Index extends Component
{

  use WithPagination;


  public $query, $nombre, $id;
  public $sinAgendar = false;
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

  public function syncToBrevo($id)
  {

    $comitente = Comitente::find($id);

    if (!$comitente || !$comitente->mail) {
      $this->dispatch('error', 'El comitente no tiene un email válido.');
      return;
    }

    $brevoService = new BrevoService();
    $result = $brevoService->createContact(
      $comitente->mail,
      [
        'NOMBRE' => $comitente->nombre,
        'APELLIDOS' => $comitente->apellido,
        // 'SMS' => $comitente->telefono ?  "54" . preg_replace('/\D/', '', $comitente->telefono) : null,
      ],
      [config('services.brevo.comitentes_list_id')]
      // [5]


    );

    // info(["service all" => config('services.brevo')]);
    // info(["service" => config('services.brevo.comitentes_list_id')]);
    // info(["service" => $result['success']]);

    if ($result['success']) {
      $comitente->update(['agendado' => true]);
      $this->dispatch('contactCreated');
      $this->dispatch('success', 'Contacto sincronizado con Brevo.');
    } else {
      info("No resulta", ["result" => $result]);
      $this->dispatch('contactErrorCreated', 'Error al sincronizar con Brevo.');
    }
  }

  public function deleteToBrevo($id)
  {

    $comitente = Comitente::find($id);
    if ($comitente->agendado && $comitente->mail) {
      $brevoService = new BrevoService();
      $result = $brevoService->deleteContact($comitente->mail);
      // $result = $brevoService->deleteContact("ww@adad.com");

      if ($result['success']) {
        $this->dispatch('contactDeleted');
        $comitente->update(['agendado' => false]);
      } else {
        info("Error al eliminar contacto de Brevo: " . $result['message']);
        $this->dispatch('contactErrorDeleted');
      }
    }
  }



  public function render()
  {

    $comitentes = Comitente::query();

    if ($this->query) {
      switch ($this->searchType) {
        case 'id':
          $comitentes->where("id",  $this->query);
          break;
        case 'nombre':
          $comitentes->where("nombre", "like", '%' . $this->query . '%');
          break;
        case 'apellido':
          $comitentes->where("apellido", "like", '%' . $this->query . '%');
          break;
        case 'telefono':
          $comitentes->where("telefono", "like", '%' . $this->query . '%');
          break;
        case 'CUIT':
          $comitentes->where("CUIT", "like", '%' . $this->query . '%');
          break;
        case 'mail':
          $comitentes->where("mail", "like", '%' . $this->query . '%');
          break;
        case 'alias':
          $comitentes->whereHas('alias', function ($query) {
            $query->where('nombre', 'like', '%' . $this->query . '%');
          });
          break;
        case 'todos':
          $comitentes->where(function ($q) {
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
    }

    if ($this->sinAgendar) {
      $comitentes->where("agendado", false);
    }

    $comitentes = $comitentes->orderBy("id", "desc")->paginate(15);




    return view('livewire.admin.comitentes.index', compact('comitentes'));
  }
}
