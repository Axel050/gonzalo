<?php

namespace App\Livewire\Admin\Contratos;

use App\Enums\LotesEstados;
use App\Models\Autorizado;
use App\Models\Adquirente;
use App\Models\Contrato;
use App\Models\Lote;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalContratoLotes extends Component

{

  public $search;
  public $lotes = [];
  public string $si;

  public $te = 1;

  public $id;

  public $contrato;
  public $nombre, $apellido, $telefono, $email, $dni;
  public $autorizados = [];
  public $tempAutorizados = [];
  public $method;

  public $estados = [];


  public function loteSelected($loteId)
  {

    $this->search = "";
    $this->si = false;
    $lote = Lote::find($loteId);
    if ($lote) {
      // $this->dispatch('loteSel', loteId: $loteId, nombre: $lote->titulo);
      $this->nombre = $lote->titulo;
    }
  }

  public function updatedSearch($value)
  {
    if (strlen($value) > 1) {
      $this->lotes = Lote::where('comitente_id', 1)
        ->where('estado', LotesEstados::DISPONIBLE)
        ->where('titulo', 'like', '%' . $value . '%')
        ->take(10)
        ->get();

      if (count($this->lotes) > 0) {
        $this->si = true;
      }
    } else {
      $this->si = false;
      $this->lotes = [];
    }
  }

  public function test()
  {
    $this->te = 5;
  }
  public function mount()
  {
    // $this->estados = LotesEstados::all();
    $this->contrato = Contrato::find($this->id);
    // $this->tempAutorizados = $this->adquirente->autorizados->toArray();
  }


  protected function rules()
  {

    $rules = [
      'nombre' => 'required',
      'apellido' => 'required',
      'telefono' => 'required',
      'email' => 'required|email',
      "dni" => [
        'required',
        'numeric',
        function ($attribute, $value, $fail) {
          $exists = Autorizado::where('dni', $value)
            ->where('adquirente_id', '!=', "0")
            ->where('adquirente_id', '!=', $this->adquirente->id)
            ->exists();

          if ($exists) {
            $fail('DNI existente en otro adquirente.');
          }
        }
      ],
    ];

    return $rules;
  }


  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "apellido.required" => "Ingrese  apellido.",
      "email.required" => "Ingrese  mail.",
      "email.email" => "Mail invalido.",
      "dni.required" => "Ingrese  dni.",
      "dni.numeric" => "Ingrese  numero.",
      "telefono.required" => "Ingrese  telefono.",
    ];
  }






  public function add()
  {
    $this->validate();

    $dniExistsInTemp = array_search($this->dni, array_column($this->tempAutorizados, 'dni')) !== false;
    if ($dniExistsInTemp) {
      $this->addError('dni', 'El DNI ya está en la lista.');
      return;
    }

    $this->tempAutorizados[] = [
      'nombre' => $this->nombre,
      'apellido' => $this->apellido,
      'dni' => $this->dni,
      'telefono' => $this->telefono,
      'email' => $this->email,
    ];

    $this->reset(['nombre', 'apellido', 'dni', 'telefono', 'email']);
  }

  public function quitar($index)
  {
    if (isset($this->tempAutorizados[$index])) {
      unset($this->tempAutorizados[$index]);
      // Reindexar el array para evitar índices vacíos
      $this->tempAutorizados = array_values($this->tempAutorizados);
    }
  }

  public function editar($index)
  {
    if (isset($this->tempAutorizados[$index])) {
      $this->nombre = $this->tempAutorizados[$index]['nombre'];
      $this->apellido = $this->tempAutorizados[$index]['apellido'];
      $this->dni = $this->tempAutorizados[$index]['dni'];
      $this->telefono = $this->tempAutorizados[$index]['telefono'];
      $this->email = $this->tempAutorizados[$index]['email'];

      // Eliminar el elemento de la lista temporal
      unset($this->tempAutorizados[$index]);
      $this->tempAutorizados = array_values($this->tempAutorizados);
    }
  }


  public function save()
  {

    // Obtener los DNI existentes en la base de datos para este adquirente
    $existingDnis = $this->adquirente->autorizados->pluck('dni')->toArray();
    $newDnis = array_column($this->tempAutorizados, 'dni');

    foreach ($existingDnis as $existingDni) {
      if (!in_array($existingDni, $newDnis)) {
        $this->adquirente->autorizados()
          ->where('dni', $existingDni)
          ->delete();
      }
    }

    // Agregar o actualizar los autorizados de $tempAutorizados
    foreach ($this->tempAutorizados as $autorizado) {
      $this->adquirente->autorizados()->updateOrCreate(
        ['dni' => $autorizado['dni']],
        $autorizado
      );
    }

    $this->dispatch('autorizadoCreated');
  }

  // public function selectLote($id, $nombre)
  #[On("loteSel")]
  public function selectLote($id, $titulo)
  {
    // $this->dispatch('loteSelected', loteId: $loteId, nombre: $lote->titulo);
    // dd($id);

    $lote = Lote::find($id);

    if ($lote) {

      $this->nombre = $lote->titulo;
    }

    // $this->reset('search');
  }


  public function render()
  {
    info("render   modal contrato lotes");
    return view('livewire.admin.contratos.modal-contrato-lotes');
  }
}
