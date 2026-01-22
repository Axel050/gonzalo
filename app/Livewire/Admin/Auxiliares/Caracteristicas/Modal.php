<?php

namespace App\Livewire\Admin\Auxiliares\Caracteristicas;

use App\Models\Caracteristica;
use App\Models\ValoresCataracteristica;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Modal extends Component
{

  public $title;
  public $id;
  public $bg;
  public $method;
  public $btnText;

  public $caracteristica;
  public $nombre;
  // public $tipo = "text";
  public $tipo = "text";

  public $opciones = [''];

  protected function rules()
  {
    $rules = [
      'nombre' => 'required|unique:caracteristicas,nombre',
    ];

    // $rules['opciones'] = 'required_if:tipo,select|array|min:2';
    if ($this->tipo == "select") {
      $rules['opciones'] = 'array|min:1';
      $rules['opciones.*'] = 'required|string';
    }

    if ($this->method == "update") {
      $rules["nombre"] = 'required|unique:caracteristicas,nombre,' . $this->caracteristica->id;
    } else {
      $rules["nombre"] = 'required|unique:caracteristicas,nombre';
    }

    return $rules;
  }



  protected function messages()
  {
    return [
      "nombre.required" => "Ingrese nombre.",
      "nombre.unique" => "Nombre existente.",
      "opciones.min" => "Agregue una opción",
      "opciones.required" => "Agregue una opción",
      "opciones.*.required" => "Ingrese una opción",
      "opciones.*.string" => "Ingrese una opción"
    ];
  }


  public function addOpcion()
  {
    $this->opciones[] = ''; // Añade una nueva opción vacía
  }

  public function removeOpcion($index)
  {
    if (count($this->opciones) > 1) {
      unset($this->opciones[$index]);
      $this->opciones = array_values($this->opciones); // Reindexa el array
    }
  }


  public function mount()
  {

    if ($this->method == "save") {

      $this->title = "Crear";
      $this->btnText = "Guardar";
      $this->bg =  "background-color: rgb(22 163 74)";
    }

    if ($this->method == "delete") {
      $this->caracteristica = Caracteristica::find($this->id);
      $this->id = $this->caracteristica->id;
      $this->title = "Eliminar";
      $this->btnText = "Eliminar";
      $this->bg =  "background-color: rgb(239 68 68)";
    }
    if ($this->method == "update" || $this->method == "view") {
      $this->caracteristica = Caracteristica::find($this->id);
      $this->nombre =  $this->caracteristica->nombre;
      $this->tipo =  $this->caracteristica->tipo;

      $this->opciones = $this->caracteristica->opciones->pluck('valor')->toArray();
      if (empty($this->opciones)) {
        $this->opciones = ['']; // Asegura al menos una opción vacía si no hay opciones
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
    // dd($this->opciones);

    $caracteristica = Caracteristica::create([
      "nombre" => $this->nombre,
      "tipo" => $this->tipo,
    ]);

    if ($this->tipo === 'select') {
      foreach ($this->opciones as $opcion) {
        $caracteristica->opciones()->create([
          'valor' => $opcion,
        ]);
      }
    }

    $this->dispatch('caracteristicaCreated');
  }


  public function update()
  {

    if (!$this->caracteristica) {
      $this->dispatch('caracteristicaNotExits');
    } else {
      $this->validate();

      $this->caracteristica->nombre = $this->nombre;
      $this->caracteristica->tipo = $this->tipo;

      $this->caracteristica->save();



      if ($this->tipo === 'select') {
        // Eliminar opciones existentes

        $opcionesEnUso = ValoresCataracteristica::where('caracteristica_id', $this->caracteristica->id)
          ->pluck('valor')
          ->unique()
          ->toArray();

        $opcionesEliminadas = array_diff($opcionesEnUso, $this->opciones);

        if (!empty($opcionesEliminadas)) {
          $this->addError('tieneDatos', 'Opción asociada a lotes.');
          $this->mount();
          return;
        }


        $this->caracteristica->opciones()->delete();
        // Crear nuevas opciones
        foreach ($this->opciones as $opcion) {
          $this->caracteristica->opciones()->create([
            'valor' => $opcion,
          ]);
        }
      } else {
        // Si no es select, eliminar todas las opciones
        $this->caracteristica->opciones()->delete();
      }



      $this->dispatch('caracteristicaUpdated');
    }
  }

  public function delete()
  {
    if (!$this->caracteristica) {
      $this->dispatch('caracteristicaNotExits');
    } else {

      if (
        DB::table('tipo_bien_caracteristicas')
        ->where('caracteristica_id', $this->caracteristica->id)
        ->exists()
      ) {
        $this->addError(
          'tieneDatos',
          'Característica está asociada a uno o más tipos de bien.'
        );
        return;
      }

      // 2️⃣ Tiene opciones definidas
      if ($this->caracteristica->opciones()->exists()) {
        $this->addError(
          'tieneDatos',
          'Característica tiene opciones configuradas.'
        );
        return;
      }

      // 3️⃣ Fue usada en algún lote
      if (
        DB::table('valores_cataracteristicas')
        ->where('caracteristica_id', $this->caracteristica->id)
        ->exists()
      ) {
        $this->addError(
          'tieneDatos',
          'Característica ya fue utilizada en lotes.'
        );
        return;
      }


      $this->caracteristica->delete();
      $this->dispatch('caracteristicaDeleted');
    }
  }

  public function render()
  {
    return view('livewire.admin.auxiliares.caracteristicas.modal');
  }
}
