<?php

namespace App\Livewire\Adquirentes;

use App\Models\CondicionIva;
use App\Services\AdquirenteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Perfil extends Component
{
  use WithFileUploads;

  public $nombre, $apellido, $mail, $telefono, $CUIT, $domicilio, $domicilio_envio, $condicion_iva_id;
  public $banco, $numero_cuenta, $CBU, $alias_bancario;
  public $adquirente;

  public $method;
  public $condiciones;
  public $editing = false;

  public function toggleEdit()
  {
    $this->editing = !$this->editing;
    if (!$this->editing) {
      $this->mount(); // Opcional: recargar datos originales si cancela
    }
  }



  public function mount()
  {

    $user = Auth::user();
    $this->adquirente = $user->adquirente;

    if ($this->adquirente) {

      $this->condiciones = CondicionIva::all();

      $this->nombre = $user->name;
      $this->apellido = $this->adquirente->apellido;
      $this->mail = $user->email;

      $this->telefono = $this->adquirente->telefono;
      $this->CUIT = $this->adquirente->CUIT;
      $this->domicilio = $this->adquirente->domicilio;
      $this->domicilio_envio = $this->adquirente->domicilio_envio;
      $this->condicion_iva_id = $this->adquirente->condicion_iva_id;
      $this->banco = $this->adquirente->banco;
      $this->CBU = $this->adquirente->CBU;
      $this->alias_bancario = $this->adquirente->alias_bancario;
      $this->numero_cuenta = $this->adquirente->numero_cuenta;
    }
  }




  protected function rules()
  {

    $rules = [
      'nombre' => 'required',
      'apellido' => 'required',
      'telefono' => 'required|unique:adquirentes,telefono,' . $this->adquirente->id,
      'CUIT' => 'nullable|unique:adquirentes,CUIT,' . $this->adquirente->id,
    ];


    return $rules;
  }

  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "apellido.required" => "Ingrese  apellido.",
      "telefono.required" => "Ingrese  telefono.",
      "telefono.unique" => "Telefono existente.",
      "CUIT.unique" => "CUIT existente.",
      // "CBU.required" => "Ingrese CBU.",
      // "numero_cuenta.required" => "Ingrese numero de cuenta.",
      // "domicilio.required" => "Ingrese domicilio.",      
    ];
  }




  public function edit(AdquirenteService $adquirenteService)
  {


    try {

      $this->validate();
      $data = [
        "id" => $this->adquirente->id,
        'nombre' => $this->nombre,
        'apellido' => $this->apellido,
        'telefono' => $this->telefono,
        'CUIT' => $this->CUIT,
        'domicilio' => $this->domicilio,
        'domicilio_envio' => $this->domicilio_envio,
        'banco' => $this->banco,
        'numero_cuenta' => $this->numero_cuenta,
        'CBU' => $this->CBU,
        'alias_bancario' => $this->alias_bancario,
        'condicion_iva_id' => $this->condicion_iva_id,
        // 'foto' => $this->foto,
      ];

      $adquirente = $adquirenteService->updateAdquirente($data);

      $this->dispatch(
        'show-message',
        message: 'Datos actualizados con éxito.',
      );

      $this->editing = false;
    } catch (ValidationException $e) {
      info('Validación fallida en Livewire', ['errors' => $e->errors()]);
      $this->setErrorBag($e->errors());
    } catch (\Exception $e) {
      info('General Exception: ' . $e->getMessage());
      session()->flash('error', 'Ocurrió un error: ' . $e->getMessage());
    }
  }

  public function render()
  {
    return view('livewire.adquirentes.perfil');
  }
}
