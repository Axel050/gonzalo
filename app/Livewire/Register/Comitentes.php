<?php

namespace App\Livewire\Register;

use App\Rules\RecaptchaRule;
use App\Services\ComitenteService;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Comitentes extends Component
{
  use WithFileUploads;

  public $nombre, $apellido, $mail, $telefono, $CUIT, $domicilio, $comision;
  public $banco, $numero_cuenta, $CBU, $alias_bancario, $observaciones, $foto;
  public $g_recaptcha_response;
  public $method;
  public $terminos;
  public function mount() {}

  protected function rules()
  {

    $rules = [
      'nombre' => 'required',
      'apellido' => 'required',
      'telefono' => 'required',
      'mail' => 'required|email|unique:comitentes,mail',
      'domicilio' => 'required',
      'CUIT' => 'unique:comitentes,CUIT',
      'terminos' => 'accepted',
      // 'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:14048',
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
      "mail.required" => "Ingrese  mail.",
      "mail.email" => "Mail invalido.",
      "mail.unique" => "Mail existente.",
      "telefono.required" => "Ingrese  telefono.",
      "CUIT.required" => "Ingrese  CUIT.",
      "CUIT.unique" => "CUIT existente.",
      "alias_id.unique" => "Alias existente.",
      "comision.required" => "Ingrese comision.",
      "comision.numeric" => "Comision invalida.",
      "comision.min" => "Comision invalida.",
      "CBU.required" => "Ingrese CBU.",
      "numero_cuenta.required" => "Ingrese numero de cuenta.",
      "domicilio.required" => "Ingrese domicilio.",
      "g_recaptcha_response" => "Corfirme que no es un robot.",
      "terminos" => "Acepte términos y condiciones.",
      'foto.image'     => 'Imagen invalida',
      'foto.mimes'     => 'Imagen invalida',
      'foto.max'     => 'menor a 14mbs',

    ];
  }

  public function save(ComitenteService $comitenteService)
  {


    try {

      $this->validate();
      $data = [
        'nombre' => $this->nombre,
        'apellido' => $this->apellido,
        'mail' => $this->mail,
        'telefono' => $this->telefono,
        'CUIT' => $this->CUIT,
        'domicilio' => $this->domicilio,
        'comision' => $this->comision,
        'banco' => $this->banco,
        'numero_cuenta' => $this->numero_cuenta,
        'CBU' => $this->CBU,
        'alias_bancario' => $this->alias_bancario,
        'observaciones' => $this->observaciones,
        // 'foto' => $this->foto,
      ];

      $comitente = $comitenteService->createComitente($data);

      $this->reset();
      $this->method = "ok";
    } catch (ValidationException $e) {
      info('Validación fallida en Livewire', ['errors' => $e->errors()]);
      $this->setErrorBag($e->errors());
    } catch (\Exception $e) {
      info('General Exception: ' . $e->getMessage());
      session()->flash('error', 'Ocurrió un error: ' . $e->getMessage());
    }

    info('EBDDDD');
  }


  public function render()
  {
    return view('livewire.register.comitentes');
  }
}
