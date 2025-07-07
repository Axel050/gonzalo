<?php

namespace App\Livewire\Register;

use App\Models\CondicionIva;
use App\Rules\RecaptchaRule;
use Livewire\Component;

use App\Services\AdquirenteService;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Adquirentes extends Component
{
  use WithFileUploads;

  public $pasP, $mailP;

  public $nombre, $apellido, $mail, $telefono, $CUIT, $domicilio;
  public $banco, $numero_cuenta, $CBU, $alias_bancario, $observaciones, $foto;
  public $password, $password_confirmation;


  public $condicion_iva_id = 4;
  public $condiciones = [];
  public $method;

  public $g_recaptcha_response;

  public function mount()
  {
    $this->condiciones = CondicionIva::all();
  }



  protected function rules()
  {
    $rules =   [
      'nombre' => 'required',
      'apellido' => 'required',
      // 'condicion_iva_id' => 'required',
      'telefono' => 'required|unique:adquirentes,telefono',
      'mail' => 'required|email|unique:users,email',
      // 'CUIT' => 'unique:adquirentes,CUIT',
      'password' => 'required|string|confirmed|min:8',
    ];
    if (!$this->g_recaptcha_response) {
      $rules['g_recaptcha_response'] = ['required', new RecaptchaRule()];
    }
    return $rules;
  }



  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "apellido.required" => "Ingrese  apellido.",
      "telefono.required" => "Ingrese  telefono.",
      "telefono.unique" => "Telefono existente.",
      // "CUIT.required" => "Ingrese  CUIT.",
      "CUIT.unique" => "CUIT existente.",
      "condicion_iva_id.required" => "Elija condicion.",
      "estado_id.required" => "Elija estado.",
      "mail.required" => "Ingrese  mail.",
      "mail.email" => "Mail invalido.",
      "mail.unique" => "Mail existente.",
      "password.confirmed" => "Confirme contraseña.",
      "password.required" => "Ingrese contraseña.",
      "password.min" => "Minimo 8 caracteres.",
      "g_recaptcha_response" => "Corfirme que no es un robot.",
    ];
  }




  public function save(AdquirenteService $adquirenteService)
  {
    try {

      $this->validate();
      $this->pasP = $this->password;
      $this->mailP = $this->mail;
      $data = [
        'nombre' => $this->nombre,
        'apellido' => $this->apellido,
        'mail' => $this->mail,
        'telefono' => $this->telefono,
        // 'CUIT' => $this->CUIT,
        'password' => $this->password,
        'password_confirmation' => $this->password_confirmation,
      ];


      $adquirente = $adquirenteService->createAdquirente($data);

      $this->pasP = $this->password;
      $this->mailP = $this->mail;
      $this->resetExcept(["mailP", "pasP"]);
      $this->method = "ok";
    } catch (ValidationException $e) {
      $this->dispatch('reset-recaptcha');
      info('Validación fallida en Livewire', ['errors' => $e->errors()]);
      $this->setErrorBag($e->errors());
    } catch (\Exception $e) {
      info('General Exception: ' . $e->getMessage());
      session()->flash('error', 'Ocurrió un error: ' . $e->getMessage());
    }
  }

  public function render()
  {
    return view('livewire.register.adquirentes');
  }
}
