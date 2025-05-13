<?php

namespace App\Livewire\Admin\Lotes;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Models\TiposBien;
use App\Models\ValoresCataracteristica;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use Livewire\Features\SupportFileUploads\WithFileUploads;

class Modal extends Component
{

  use WithFileUploads;


  public $test;
  public $comitente;

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $contrato;
  public $contrato_id;
  public $nombre;

  public $descripcion;
  public $valuacion;
  public $base;
  public $fraccion_min;
  public $venta_directa;
  public $precio_venta_directa;


  public $lotes = true;
  public $comitente_id;

  public $subastas = [];
  public $comitentes = [];
  public $monedas = [];
  public $moneda_id;

  public $tipos = [];
  public $tipo_bien_id;
  public $caracteristicas;

  public $adquirente_id, $subasta_id, $monto, $fecha, $fecha_devolucion, $estado;

  public $foto1, $foto2, $foto3;
  public $lote;
  public $titulo;




  public $formData = [];
  public $rules = [];


  protected function messages()
  {
    return [
      "comitente_id.required" => "Elija comitente.",
      "tipo_bien_id.required" => "Elija tipo.",
      'formData.*.required' => 'Este campo es obligatorio.',
    ];
  }


  public function updatedTipoBienId($value)
  {
    // Buscar el tipo seleccionado
    $tipo = TiposBien::find($value);

    // Obtener las características asociadas con el campo 'requerido' desde la tabla pivote
    $this->caracteristicas = $tipo ? $tipo->caracteristicas()->get() : [];

    // Resetear formData y reglas de validación
    $this->formData = [];
    $this->rules = [
      'comitente_id' => 'required', // Mantener regla estática
      'tipo_bien_id' => 'required|exists:tipos_biens,id', // Ahora es requerido
    ];

    // Inicializar formData y configurar reglas de validación para características
    foreach ($this->caracteristicas as $caracteristica) {
      $model = 'formData.' . $caracteristica->id;
      $this->formData[$caracteristica->id] = '';

      // Añadir reglas según si es requerido
      $this->rules[$model] = $caracteristica->pivot->requerido ? 'required' : 'nullable';

      // Ajustar reglas según el tipo de input
      if ($caracteristica->tipo === 'number') {
        $this->rules[$model] .= '|numeric';
      } elseif ($caracteristica->tipo === 'text') {
        $this->rules[$model] .= '|string';
      }
      // Añadir más tipos según sea necesario (email, date, etc.)
    }
  }



  public function mount()
  {

    $this->rules = [
      'comitente_id' => 'required',
      'tipo_bien_id' => 'nullable|exists:tipos_biens,id', // Inicialmente nullable
    ];


    $this->subastas = Subasta::orderBy("id")->get();
    // $this->comitentes = Comitente::with("alias")->orderBy("nombre")->get();
    $this->tipos = TiposBien::orderBy("nombre")->get();
    $this->monedas = Moneda::orderBy("titulo")->get();


    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->contrato = Contrato::find($this->id);
      $this->id = $this->contrato->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->lote = Lote::find($this->id);
      $this->comitente_id =  $this->lote->comitente_id;
      $this->comitente = $this->lote->comitente?->alias?->nombre . " - " . $this->lote->comitente?->nombre  . " " . $this->lote->comitente?->apellido;
      $this->subasta_id =  $this->lote->ultimoContrato?->subasta_id;
      $this->base =  (int)$this->lote->precio_base;

      $this->contrato_id =  $this->lote->ultimo_contrato;
      $this->descripcion =  $this->lote->descripcion;
      $this->valuacion = (int)$this->lote->valuacion;
      $this->venta_directa =  $this->lote->venta_directa;
      $this->precio_venta_directa =  $this->lote->precio_venta_directa;
      $this->estado =  $this->lote->estado;
      $this->moneda_id =  $this->lote->ultimoConLote?->moneda_id;
      $this->titulo =  $this->lote->titulo;
      $this->fraccion_min =  $this->lote->fraccion_min;

      $this->tipo_bien_id =  $this->lote->tipo_bien_id;
      if ($this->tipo_bien_id) {
        $tipo = TiposBien::find($this->tipo_bien_id);
        $this->caracteristicas = $tipo ? $tipo->caracteristicas()->get() : [];

        $this->formData = [];
        foreach ($this->caracteristicas as $caracteristica) {
          $this->formData[$caracteristica->id] = '';

          // Buscar el valor de la característica en valores_cataracteristicas
          if ($this->lote) {
            $valorCaracteristica = $this->lote->valoresCaracteristicas()
              ->where('caracteristica_id', $caracteristica->id)
              ->first();
            if ($valorCaracteristica) {
              $this->formData[$caracteristica->id] = $valorCaracteristica->valor;
            }
          }

          // Configurar reglas de validación
          $model = 'formData.' . $caracteristica->id;
          $this->rules[$model] = $caracteristica->pivot->requerido ? 'required' : 'nullable';

          // if ($caracteristica->tipo === 'number') {
          //   $this->rules[$model] .= '|numeric';
          // } elseif ($caracteristica->tipo === 'text') {
          //   $this->rules[$model] .= '|string';
          // }
          // Añadir más tipos según sea necesario
        }

        info($this->lote->valoresCaracteristicas);
      }


      if ($this->method == "update") {
        $this->title = "Editar";
        $this->bg = "background-color: rgb(234 88 12)";
        $this->btnText = "Guardar";
      } else {
        $this->title = "Ver";
        $this->bg =  "background-color: rgb(31, 83, 44)";
      }
    }
  }


  public function save()
  {


    $this->validate();

    dd("ad");
    $contrato  = Contrato::create([
      "comitente_id" => $this->comitente_id,
      "descripcion" => $this->descripcion,
      "subasta_id" => $this->subasta_id,
      "fecha_firma" => $this->fecha,
    ]);



    if ($this->lotes && $contrato) {
      return $this->dispatch("lotes", $contrato->id);
    }

    $this->dispatch('contratoCreated');
  }


  public function update()
  {

    if (!$this->lote) {
      $this->dispatch('loteNotExits');
    } else {
      $this->validate();

      // Iniciar una transacción para asegurar consistencia
      DB::transaction(function () {
        // Obtener los IDs de las características válidas para el tipo de bien
        $caracteristicaIds = $this->caracteristicas->pluck('id')->toArray();

        foreach ($this->formData as $caracteristicaId => $valor) {
          // Asegurarse de que la característica es válida
          if (in_array($caracteristicaId, $caracteristicaIds)) {
            // Buscar o crear el registro en valores_cataracteristicas
            ValoresCataracteristica::updateOrCreate(
              [
                'lote_id' => $this->lote->id,
                'caracteristica_id' => $caracteristicaId,
              ],
              [
                'valor' => $valor,
              ]
            );
          }
        }

        // // Opcional: Eliminar registros de valores_cataracteristicas que no están en formData
        // ValoresCataracteristica::where('lote_id', $this->lote->id)
        //   ->whereNotIn('caracteristica_id', array_keys($this->formData))
        //   ->delete();

        // Actualizar otros campos del lote si es necesario
        $this->lote->update([
          // Por ejemplo, actualizar tipo_bien_id o comitente_id si están en el formulario
          'tipo_bien_id' => $this->tipo_bien_id,
          // Otros campos...
        ]);
      });

      dd($this->formData);
      $this->contrato->subasta_id = $this->subasta_id;
      $this->contrato->adquirente_id = $this->adquirente_id;
      $this->contrato->monto = $this->monto;
      $this->contrato->estado = $this->estado;
      $this->contrato->fecha = $this->fecha;
      $this->contrato->fecha_devolucion = $this->fecha_devolucion ? $this->fecha_devolucion :  NULL;

      $this->contrato->save();
      $this->dispatch('contratoUpdated');
    }
  }

  public function delete()
  {
    if (!$this->contrato) {
      $this->dispatch('contratoNotExits');
    } else {
      $this->contrato->delete();
      $this->dispatch('contratoDeleted');
    }
  }

  public function render()
  {
    return view('livewire.admin.lotes.modal');
  }
}
