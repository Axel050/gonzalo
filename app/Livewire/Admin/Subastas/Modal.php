<?php

namespace App\Livewire\Admin\Subastas;

use App\Enums\SubastaEstados;
use App\Models\Subasta;
use Carbon\Carbon;
use Livewire\Component;

class Modal extends Component
{

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $subasta;

  public $estado;

  public $pausar = 0;

  public $tiempoPos = "2";

  public $tiempoIni = "00:00";
  public $tiempoFin = "00:00";

  public $iniD;
  public $iniH = "00:00";

  public $finD;
  public $finH = "23:59";

  public $comision = 20;
  public $garantia = 0;
  public $envio = 0;

  public $titulo;
  public $descripcion;
  public $num;

  public $estados;




  protected function rules()
  {

    $rules = [
      'titulo' => 'required|unique:subastas,titulo',
      'iniD' => 'required',
      'iniH' => 'required',
      'finD' => 'required',
      'finH' => 'required',
      'comision' => 'required|numeric|min:0',
      'tiempoPos' => 'required',
      'garantia' => 'required|numeric|min:1',
      'envio' => 'numeric|min:0',
    ];
    if ($this->method == "update") {
      $rules["titulo"] = 'required|unique:subastas,titulo,' . $this->subasta->id;
    } else {
      $rules["titulo"] = 'required|unique:subastas,titulo';
    }

    return $rules;
  }

  protected function messages()
  {
    return [
      "envio" => "Ingrese monto.",
      "titulo.required" => "Ingrese titulo.",
      "titulo.unique" => "Titulo existente.",
      "iniD.required" => "Ingrese  fecha inicio.",
      "iniH.required" => "Ingrese  hora inicio.",
      "finD.required" => "Ingrese  fecha fin.",
      "finH.required" => "Ingrese  hora fin.",
      "comision.required" => "Ingrese  comision.",
      "comision.numeric" => "Comision invalida.",
      "comision.min" => "Comision invalida.",
      "tiempoPos.required" => "Ingrese  tiempo post subasta.",
      "garantia.required" => "Ingrese  monto.",
      "garantia.min" => "Ingrese  monto.",
    ];
  }


  public function ti()
  {
    dd([
      "inicFec" => $this->iniD,
      "inicHo" => $this->iniH
    ]);
  }

  public function mount()
  {
    // dd("Comprobar si subasta estado en puja , pausar , que pasa , se debe poder pausar en puja ? ");

    $this->estados = array_map(function ($estado) {
      return [
        'value' => $estado,
        'label' => SubastaEstados::getLabel($estado),
      ];
    }, SubastaEstados::all());


    if ($this->method == "save") {
      $this->num = Subasta::max('id') + 1;

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->subasta = Subasta::find($this->id);
      $this->id = $this->subasta->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->subasta = Subasta::find($this->id);

      $this->num =  $this->subasta->id;
      $this->titulo =  $this->subasta->titulo;
      $this->envio =  $this->subasta->envio;
      $this->descripcion =  $this->subasta->descripcion;

      if ($this->subasta->comision !== null) {
        $comision = floatval($this->subasta->comision);
        $comision = ($comision == floor($comision)) ? (int)$comision : $comision;
        $this->comision =  $comision;
      }

      $this->garantia =  $this->subasta->garantia;
      // $this->estado =  $this->subasta->estado;
      $this->estado =  SubastaEstados::getLabel($this->subasta->estado);
      $this->tiempoPos =  $this->subasta->tiempo_post_subasta;

      $carbonIni = Carbon::parse($this->subasta->fecha_inicio);
      $this->iniD = $carbonIni->toDateString();
      $this->iniH = $carbonIni->format('H:i');

      $carbonFin = Carbon::parse($this->subasta->fecha_fin);
      $this->finD = $carbonFin->toDateString();
      $this->finH = $carbonFin->format('H:i');

      if ($this->method == "update") {
        $this->title = "Editar";
        $this->bg = "background-color: rgb(234 88 12)";
        $this->btnText = "Guardar";
      } else {
        $this->title = "Ver";
        $this->bg =  "background-color: rgb(31, 83, 44)";
      }
      // $this->bg="background-color: rgb(234 88 12)";
    }
  }


  public function save()
  {

    $this->validate($this->rules(), $this->messages());

    Subasta::create([
      "titulo" => $this->titulo,
      "comision" => (int)$this->comision,
      "tiempo_post_subasta" => $this->tiempoPos,
      "descripcion" => $this->descripcion,
      "garantia" => (int) $this->garantia,
      "estado" => SubastaEstados::INACTIVA,
      "fecha_inicio" => $this->iniD . " " . $this->iniH,
      "fecha_fin" => $this->finD . " " . $this->finH,
      "envio" => !empty($this->envio) ? $this->envio : 0
    ]);

    $this->dispatch('subastaCreated');
  }


  public function update()
  {

    if (!$this->subasta) {
      $this->dispatch('subastaNotExits');
    } else {
      $this->validate($this->rules(), $this->messages());


      $this->subasta->titulo = $this->titulo;
      $this->subasta->descripcion = $this->descripcion;
      $this->subasta->comision = $this->comision;
      $this->subasta->tiempo_post_subasta = $this->tiempoPos;
      // $this->subasta->envio = $this->envio ?? 0;
      $this->subasta->envio = !empty($this->envio) ? $this->envio : 0;


      info(["ESTADO" => $this->subasta->estado]);
      if ($this->subasta->estado == SubastaEstados::PAUSADA && $this->pausar) {
        $this->subasta->estado = SubastaEstados::ACTIVA;
      } elseif (($this->subasta->estado == SubastaEstados::ACTIVA || $this->subasta->estado == SubastaEstados::ENPUJA) && $this->pausar) {
        $this->subasta->estado = SubastaEstados::PAUSADA;
      }

      if ($this->pausar) {
      }
      // $this->subasta->estado =$this->subasta->estado "pausada";


      $this->subasta->garantia = (int)$this->garantia;
      $this->subasta->fecha_inicio = $this->iniD . " " . $this->iniH;
      $this->subasta->fecha_fin = $this->finD . " " . $this->finH;


      $this->subasta->save();
      $this->dispatch('subastaUpdated');
    }
  }

  public function delete()
  {

    if (!$this->subasta) {
      $this->dispatch('subastaNotExits');
    } else {

      $tieneContratos = $this->subasta->contratos()->withTrashed()->exists();

      if ($tieneContratos) {
        $this->addError('tieneContratos', 'Subasta con contratos  asociados');
        return;
      }


      $this->subasta->delete();
      $this->dispatch('subastaDeleted');
    }
  }




  public function render()
  {
    return view('livewire.admin.subastas.modal');
  }
}
