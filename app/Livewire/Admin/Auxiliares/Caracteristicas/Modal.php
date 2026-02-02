<?php

namespace App\Livewire\Admin\Auxiliares\Caracteristicas;

use App\Models\Caracteristica;
use App\Models\CaracteristicaOpcion;
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
  public $tipo = "text";

  public $opciones = [];



  protected function rules()
  {
    $rules = [
      'nombre' => 'required|unique:caracteristicas,nombre',
      'tipo'   => 'required',
    ];

    if ($this->method === 'update') {
      $rules['nombre'] =
        'required|unique:caracteristicas,nombre,' . $this->caracteristica->id;
    }

    if ($this->tipo === 'select') {
      $rules['opciones'] = 'required|array|min:1';
      $rules['opciones.*.valor'] = 'required|string';
    }

    return $rules;
  }



  protected function messages()
  {
    return [
      'nombre.required' => 'Ingrese nombre.',
      'nombre.unique'   => 'Nombre existente.',
      'opciones.required' => 'Agregue al menos una opción.',
      'opciones.array' => 'Formato inválido.',
      'opciones.*.valor.required' => 'Ingrese una opción.',
    ];
  }






  public function addOpcion()
  {
    $this->opciones[] = [
      'id' => null,
      'valor' => ''
    ];
  }



  public function removeOpcion($index)
  {
    if (count($this->opciones) > 0) {
      unset($this->opciones[$index]);
      $this->opciones = array_values($this->opciones); // Reindexa el array
    }
  }






  public function mount()
  {


    if ($this->method == "save") {
      $this->addOpcion();

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



    if ($this->method === 'update' || $this->method === 'view') {
      $this->caracteristica = Caracteristica::find($this->id);

      $this->nombre = $this->caracteristica->nombre;
      $this->tipo   = $this->caracteristica->tipo;

      $this->opciones = $this->caracteristica->opciones
        ->map(fn($o) => [
          'id' => $o->id,
          'valor' => $o->valor,
        ])
        ->toArray();

      if (empty($this->opciones)) {
        $this->addOpcion();
      }
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


  public function mou33nt()
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

      // $this->opciones = $this->caracteristica->opciones->pluck('valor')->toArray();
      // if (empty($this->opciones)) {
      //   $this->opciones = ['']; // Asegura al menos una opción vacía si no hay opciones
      // }

      $this->opciones = $this->caracteristica->opciones
        ->map(fn($o) => [
          'id' => $o->id,
          'valor' => $o->valor,
        ])
        ->toArray();

      if (empty($this->opciones)) {
        $this->addOpcion();
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
          'valor' => $opcion['valor'], // ✅
        ]);
      }
    }

    $this->dispatch('caracteristicaCreated');
  }


  public function update222()
  {
    if (!$this->caracteristica) {
      $this->dispatch('caracteristicaNotExits');
      return;
    }

    $this->validate();

    // 🔒 Opciones actuales en DB
    $opcionesDB = $this->caracteristica->opciones()
      ->get(['id', 'valor']);

    // 🔒 Valores usados en lotes
    $valoresEnUso = ValoresCataracteristica::where(
      'caracteristica_id',
      $this->caracteristica->id
    )
      ->pluck('valor')
      ->unique()
      ->toArray();

    // 🔒 IDs de opciones que están en uso
    $idsOpcionesEnUso = $opcionesDB
      ->filter(fn($op) => in_array($op->valor, $valoresEnUso))
      ->pluck('id')
      ->toArray();

    // 🔒 IDs enviados desde el formulario
    $idsFormulario = collect($this->opciones)
      ->pluck('id')
      ->filter()
      ->toArray();

    // ❌ SOLO si intenta eliminar una opción usada
    $eliminadas = array_diff($idsOpcionesEnUso, $idsFormulario);

    if (!empty($eliminadas)) {
      $this->addError(
        'tieneDatos',
        'No puede eliminar opciones asociadas a lotes.'
      );
      return;
    }


    DB::transaction(function () {

      // 1️⃣ Actualiza característica
      $this->caracteristica->update([
        'nombre' => $this->nombre,
        'tipo'   => $this->tipo,
      ]);

      if ($this->tipo !== 'select') {
        $this->caracteristica->opciones()->delete();
        return;
      }

      // 2️⃣ Sync opciones
      foreach ($this->opciones as $opcion) {
        if (!empty($opcion['id'])) {
          CaracteristicaOpcion::where('id', $opcion['id'])
            ->update(['valor' => $opcion['valor']]);
        } else {
          $this->caracteristica->opciones()->create([
            'valor' => $opcion['valor'],
          ]);
        }
      }
    });

    $this->dispatch('caracteristicaUpdated');
  }



  // Si modifica opcion que estaba ligada a un lote , en el modal lote , no estara seleccionada , pero en el front aun se vera el valor viejo ,  hasta que vuelva a select en el modal lote la nueva opcion 
  public function update()
  {
    if (!$this->caracteristica) {
      $this->dispatch('caracteristicaNotExits');
      return;
    }

    $this->validate();

    // 🔒 Opciones actuales en BD
    $opcionesDB = $this->caracteristica->opciones()->get(['id', 'valor']);

    // 🔒 Valores usados en lotes
    $valoresEnUso = ValoresCataracteristica::where(
      'caracteristica_id',
      $this->caracteristica->id
    )->pluck('valor')->unique()->toArray();

    // 🔒 IDs de opciones en uso
    $idsEnUso = $opcionesDB
      ->filter(fn($op) => in_array($op->valor, $valoresEnUso))
      ->pluck('id')
      ->toArray();

    // 🔒 IDs enviados por el formulario
    $idsFormulario = collect($this->opciones)
      ->pluck('id')
      ->filter()
      ->toArray();

    // ❌ Bloquea solo si intenta borrar una opción usada
    $eliminadasEnUso = array_diff($idsEnUso, $idsFormulario);

    if (!empty($eliminadasEnUso)) {
      $this->addError(
        'tieneDatos',
        'No puede eliminar opciones asociadas a lotes.'
      );
      return;
    }

    DB::transaction(function () use ($idsFormulario) {

      // 1️⃣ Update característica
      $this->caracteristica->update([
        'nombre' => $this->nombre,
        'tipo'   => $this->tipo,
      ]);

      if ($this->tipo !== 'select') {
        $this->caracteristica->opciones()->delete();
        return;
      }

      // 2️⃣ Eliminar opciones quitadas
      $this->caracteristica->opciones()
        ->whereNotIn('id', $idsFormulario)
        ->delete();

      // 3️⃣ Update / Create opciones
      foreach ($this->opciones as $opcion) {
        if (!empty($opcion['id'])) {
          CaracteristicaOpcion::where('id', $opcion['id'])
            ->update(['valor' => $opcion['valor']]);
        } else {
          $this->caracteristica->opciones()->create([
            'valor' => $opcion['valor'],
          ]);
        }
      }
    });

    $this->dispatch('caracteristicaUpdated');
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
