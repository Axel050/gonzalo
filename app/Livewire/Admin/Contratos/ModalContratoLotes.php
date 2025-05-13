<?php

namespace App\Livewire\Admin\Contratos;

use App\Enums\LotesEstados;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Moneda;
use Livewire\Component;

class ModalContratoLotes extends Component

{

  public $modal_foto = false;
  public $search;
  public $lotes = [];
  public $monedas = [];
  public string $si;

  public $te = 1;

  public $id;
  public $foto1;

  public $moneda_id;
  public $contrato;
  public $lote_id = false;
  public $titulo, $descripcion, $precio_base;
  public $autorizados = [];

  public $tempLotes = [];
  public $method;


  public function closeModal()
  {
    // Dispara el evento para cerrar el modal en Alpine.js
    $this->dispatch('close-modal');
    // Limpia la propiedad después de la animación
    $this->modal_foto = null;
  }




  public function limpiar()
  {
    $this->lote_id = false;
    $this->titulo = "";
    $this->descripcion = "";
    $this->moneda_id = "";
    $this->precio_base = 0;
    $this->foto1 = "";
    $this->resetErrorBag('titulo');
  }

  public function loteSelected($loteId)
  {

    $this->search = "";
    $this->si = false;
    $lote = Lote::find($loteId);
    if ($lote) {
      $this->titulo = $lote->titulo;
      $this->descripcion = $lote->descripcion;
      $this->foto1 = $lote->foto1;
      $this->precio_base = (int)$lote->precio_base;
      $this->moneda_id = $lote->ultimoContratoLote?->moneda_id;
      // $ultimoContratoLote = $lote->contratosLotes()
      //   ->orderBy('id', 'desc')
      //   ->first();
      // if ($ultimoContratoLote) {
      //   $this->precio_base = (int)$ultimoContratoLote->precio_base;
      // }

      $this->lote_id = $loteId;
    }
  }

  public function updatedSearch($value)
  {

    if (strlen($value) > 1) {
      $this->lotes = Lote::where('comitente_id', $this->contrato->comitente_id)
        ->where('estado', LotesEstados::DISPONIBLE)
        ->where('titulo', 'like', '%' . $value . '%')
        ->take(10)
        ->get();
      $this->si = true;
    } else {
      $this->si = false;
      $this->lotes = [];
    }
  }


  public function mount()
  {

    // $this->monedas = Moneda::all();
    $this->monedas = Moneda::all()->keyBy('id');
    info($this->monedas[2]);
    $this->contrato = Contrato::find($this->id);
    // $this->tempLotes = $this->contrato->lotes->toArray();
    $this->tempLotes = $this->contrato->lotes->map(function ($lote) {
      $array = $lote->toArray();
      $array['precio_base'] = $lote->pivot?->precio_base;
      $array['moneda_id'] = $lote->ultimoContratoLote?->moneda_id;
      return $array;
    })->toArray();
    info($this->tempLotes);
  }


  protected function rules()
  {
    $rules = [
      'titulo' => 'required',
      'precio_base' => 'required|numeric',
      'moneda_id' => 'required',
    ];
    return $rules;
  }


  protected function messages()
  {
    return [
      "titulo.required" => "Ingrese titulo.",
      "precio_base.required" => "Ingrese  base.",
      "precio_base.numeric" => "Ingrese  numero.",
      "moneda_id.required" => "Elija moneda.",
    ];
  }



  public function add()
  {
    $this->validate();

    $tituloExistsInTemp = array_search($this->titulo, array_column($this->tempLotes, 'titulo')) !== false;
    if ($tituloExistsInTemp) {
      $this->addError('titulo', 'El titulo ya está en la lista.');
      return;
    }
    $this->resetErrorBag('titulo');

    $this->tempLotes[] = [
      'titulo' => $this->titulo,
      'descripcion' => $this->descripcion,
      'precio_base' => $this->precio_base,
      'id' => $this->lote_id,
      'foto1' => $this->foto1,
      'moneda_id' => $this->moneda_id,
    ];

    $this->reset(['titulo', 'descripcion', 'precio_base', 'lote_id', 'foto1', 'moneda_id']);
  }

  public function quitar($index)
  {
    if (isset($this->tempLotes[$index])) {
      unset($this->tempLotes[$index]);
      // Reindexar el array para evitar índices vacíos
      $this->tempLotes = array_values($this->tempLotes);
    }
  }

  public function editar($index)
  {
    if (isset($this->tempLotes[$index])) {
      $this->titulo = $this->tempLotes[$index]['titulo'];
      $this->descripcion = $this->tempLotes[$index]['descripcion'];
      $this->precio_base = $this->tempLotes[$index]['precio_base'];
      $this->lote_id = $this->tempLotes[$index]['id'];
      $this->moneda_id = $this->tempLotes[$index]['moneda_id'];

      // Eliminar el elemento de la lista temporal
      unset($this->tempLotes[$index]);
      $this->tempLotes = array_values($this->tempLotes);
    }
  }


  public function save()
  {

    $existingIds = $this->contrato->lotes->pluck('id')->toArray();

    // Obtener los IDs de los lotes en $tempLotes
    $tempIds = collect($this->tempLotes)->pluck('id')->filter()->toArray(); // Filtra IDs válidos (excluye false/null)

    $lotesToDelete = array_diff($existingIds, $tempIds);
    if (!empty($lotesToDelete)) {

      ContratoLote::where('contrato_id', $this->contrato->id)
        ->whereIn('lote_id', $lotesToDelete)
        ->delete();
    }

    // 2. Procesar cada elemento en $tempLotes
    foreach ($this->tempLotes as $tempLote) {

      if ($tempLote['id']) {

        $contratoLote = ContratoLote::where('contrato_id', $this->contrato->id)
          ->where('lote_id', $tempLote['id'])
          ->first();



        if ($contratoLote) {
          $contratoLote->update([
            'precio_base' => $tempLote['precio_base'],
          ]);
        } else {
          ContratoLote::create([
            "contrato_id" => $this->contrato->id,
            "lote_id" => $tempLote['id'],
            "precio_base" => $tempLote['precio_base'],
            "moneda_id" => $tempLote['moneda_id'],
          ]);

          Lote::find($tempLote['id'])->update(['ultimo_contrato' => $this->contrato->id]);
          info([
            "lllloooooo" => "ada",
            "lote temp" => $tempLote["id"]
          ]);
        }
      } else {

        $newLote = Lote::create([
          'titulo' => $tempLote['titulo'],
          'descripcion' => $tempLote['descripcion'],
          'comitente_id' => $this->contrato?->comitente_id,
          'ultimo_contrato' => $this->contrato?->id,
        ]);

        ContratoLote::create([
          'contrato_id' => $this->contrato->id,
          'lote_id' => $newLote->id,
          'precio_base' => $tempLote['precio_base'],
          'moneda_id' => $tempLote['moneda_id'],
        ]);
      }
    }

    $this->contrato->save();

    $this->dispatch('loteCreated');
  }




  public function render()
  {
    return view('livewire.admin.contratos.modal-contrato-lotes');
  }
}
