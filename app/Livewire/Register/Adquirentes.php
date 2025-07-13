<?php

namespace App\Livewire\Register;

use App\Events\SubastaEstadoActualizado;
use App\Models\CondicionIva;
use App\Models\ContratoLote;
use App\Models\Subasta;
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

  public function comprobar()
  {

    info("START");


    $s =  Subasta::where('estado', '1')
      ->where('fecha_fin', '<', now())->first();

    info(["FID" => $s?->id]);
    info([$s?->lotesActivos()->get()->toArray()]);
    info("-------------");


    Subasta::where('estado', '1')
      ->where('fecha_fin', '<', now())
      ->each(function ($subasta) {
        $lotesActualizados = false;
        info(["subasta ID " => $subasta->id]);

        // Obtener los IDs de los lotes que necesitan ser actualizados
        // $lotesParaActualizar = $subasta->lotesActivos()
        //   ->where(function ($query) {
        //     $query->whereNull('contrato_lotes.tiempo_post_subasta_fin')
        //       ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '<', now());
        //   })
        //   ->pluck('lotes.id', 'lotes.ultimo_contrato');

        $query = $subasta->lotesActivos()
          ->where(function ($query) {
            $query->whereNull('contrato_lotes.tiempo_post_subasta_fin')
              ->orWhere('contrato_lotes.tiempo_post_subasta_fin', '<', now());
          });
        info(['SQL' => $query->toSql(), 'bindings' => $query->getBindings()]);
        $lotesParaActualizarFull = $query->get();
        info(["lotesParaActualizarFull" => $lotesParaActualizarFull->toArray()]);
        info(["lotesParaActualizaXXX" => $subasta->lotesActivos()->get()]);

        // Obtener pares lote_id y contrato_id
        $lotesParaActualizar = $lotesParaActualizarFull->map(function ($lote) {
          return [
            'lote_id' => $lote->id,
            // 'contrato_id' => $lote->contrato_id
            'contrato_id' => 6
          ];
        })->values();

        info(["lotes para actualizarANTES" => $lotesParaActualizar->toArray()]);





        if ($lotesParaActualizar->isNotEmpty()) {

          // // Actualización masiva en contrato_lotes
          // $affectedRows = ContratoLote::whereIn('lote_id', $lotesParaActualizar->keys())
          //   ->whereIn('contrato_id', $lotesParaActualizar->values())
          //   ->update(['estado' => 'inactivo']);

          // Actualización masiva
          $affectedRows = \App\Models\ContratoLote::whereIn('lote_id', $lotesParaActualizar->pluck('lote_id'))
            ->whereIn('contrato_id', $lotesParaActualizar->pluck('contrato_id'))
            ->update(['estado' => 'inactivo']);


          if ($affectedRows > 0) {
            $lotesActualizados = true;
          }
        }

        info("refreeee");
        info(["refreeee" => $subasta->lotesActivos()->exists()]);

        $subasta->refresh();
        // if (!$subasta->lotesActivos()->exists()) {
        // Si no quedan lotes o contratos lotes activos , recien ahi desactiva la subasta  ******
        // Ver tiempo post subasta para ver cuales quedan en puja******
        // No probe descmentado lotestParaActualizar where -> query  ******
        if (!$subasta->lotesActivos()->exists() && $subasta->estado == "1") {
          info("infdddd");
          $subasta->update(['estado' => '0']);
          info(["subasta actualizada a inactiva" => $subasta->id]);
        }

        if ($lotesActualizados || $subasta->wasChanged('estado')) {
          info("EVENT IF");
          // event(new SubastaEstadoActualizado($subasta));
        }
      });
  }


  public function evento()
  {
    info("evenntoto");
    $su = Subasta::find(9);
    event(new SubastaEstadoActualizado($su));
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
