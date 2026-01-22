<?php

namespace App\Livewire\Admin\Contratos;

use App\Enums\LotesEstados;
use App\Mail\ContratoEmail;
use App\Models\CarritoLote;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\OrdenLote;
use App\Models\Puja;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalContratoLotes extends Component

{
  public $new;

  public $modal_foto = false;
  public $search;
  public $lotes = [];
  public $monedas = [];
  public string $si;

  public $te = 1;

  public $id;
  public $foto1;

  public $moneda_id = 1; //peso
  public $contrato;
  public $lote_id = false;
  public $lote_id_modal = false;
  public $titulo, $descripcion, $precio_base;
  public $autorizados = [];

  public $tempLotes = [];
  public $method;
  public $valuacion;


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
      $this->valuacion = $lote->valuacion;
      $this->foto1 = $lote->foto1;
      $this->precio_base = (int)$lote->precio_base;
      $this->moneda_id = $lote->ultimoContratoLote?->moneda_id ?? 1;
      // $ultimoContratoLote = $lote->contratosLotes()
      //   ->orderBy('id', 'desc')
      //   ->first();
      // if ($ultimoContratoLote) {
      //   $this->precio_base = (int)$ultimoContratoLote->precio_base;
      // }

      $this->lote_id = $loteId;
    }
  }
  public function updatedValuacion($value)
  {
    $this->precio_base = $value;
    info(["precio base vaue" => $value]);
    info(["precio base" => $this->precio_base]);
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


  #[On(['loteUpdated', 'loteContrato'])]
  public function mount()
  {

    // $this->monedas = Moneda::all();
    $this->monedas = Moneda::all()->keyBy('id');

    info(["oprevio mont contrato " => $this->id]);
    $this->contrato = Contrato::find($this->id);
    // $this->tempLotes = $this->contrato->lotes->toArray();
    $this->tempLotes = $this->contrato->lotes->map(function ($lote) {
      $array = $lote->toArray();
      $array['precio_base'] = $lote->pivot?->precio_base;
      $array['moneda_id'] = $lote->ultimoConLote?->moneda_id;
      return $array;
    })->toArray();
    info("tempLotes");
    info($this->tempLotes);
    info("EMND");

    $this->method = "";
  }


  protected function rules()
  {
    $rules = [
      'titulo' => 'required',
      'precio_base' => 'required|numeric|min:1',
      'moneda_id' => 'required',
      'valuacion' => 'required',
    ];
    return $rules;
  }


  protected function messages()
  {
    return [
      "titulo.required" => "Ingrese titulo.",
      "precio_base.required" => "Ingrese base.",
      "precio_base.numeric" => "Ingrese numero.",
      "precio_base.min" => "Ingrese base.",
      "moneda_id.required" => "Elija moneda.",
      "valuacion.required" => "Ingrese valuación.",
    ];
  }



  public function addComplete()
  {

    $this->validate();

    $newLote = Lote::create([
      'titulo' => $this->titulo,
      'descripcion' => $this->descripcion,
      'valuacion' => $this->valuacion,
      'comitente_id' => $this->contrato?->comitente_id,
      'ultimo_contrato' => $this->contrato?->id,
      'estado' => LotesEstados::ASIGNADO,
    ]);

    ContratoLote::create([
      'contrato_id' => $this->contrato->id,
      'lote_id' => $newLote->id,
      'precio_base' => $this->precio_base,
      'moneda_id' => $this->moneda_id,
    ]);

    $this->reset(['titulo', 'descripcion', 'precio_base', 'lote_id', 'foto1', 'moneda_id', 'valuacion']);
    $this->lote_id_modal = $newLote->id;
    $this->method = "update";
  }


  public function add()
  {
    $this->validate();

    // $tituloExistsInTemp = array_search($this->titulo, array_column($this->tempLotes, 'titulo')) !== false;
    // if ($tituloExistsInTemp) {
    //   $this->addError('titulo', 'El titulo ya está en la lista.');
    //   return;
    // }
    // $this->resetErrorBag('titulo');

    // $this->tempLotes[] = [
    array_unshift($this->tempLotes, [
      'titulo' => $this->titulo,
      'descripcion' => $this->descripcion,
      'precio_base' => $this->precio_base,
      'valuacion' => $this->valuacion,
      'id' => $this->lote_id,
      'foto1' => $this->foto1,
      'moneda_id' => $this->moneda_id,
    ]);

    $this->reset(['titulo', 'descripcion', 'precio_base', 'lote_id', 'foto1', 'moneda_id', 'valuacion']);
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
      $this->precio_base = (int)$this->tempLotes[$index]['precio_base'];
      $this->lote_id = $this->tempLotes[$index]['id'];
      $this->moneda_id = $this->tempLotes[$index]['moneda_id'];
      $this->valuacion = $this->tempLotes[$index]['valuacion'];

      if ($this->tempLotes[$index]['foto1']) {
        $this->foto1 = $this->tempLotes[$index]['foto1'];
      }

      // Eliminar el elemento de la lista temporal
      unset($this->tempLotes[$index]);
      $this->tempLotes = array_values($this->tempLotes);
    }
  }




  public function save($send = false)
  {

    $this->validate([
      // 'tempLotes' => 'required|array|min:1',
      'tempLotes.required' => 'Debe agregar al menos un lote.',
      'tempLotes.min' => 'Debe agregar al menos un lote.',
    ]);

    $existingIds = $this->contrato->lotes->pluck('id')->toArray();

    // Obtener los IDs de los lotes en $tempLotes
    $tempIds = collect($this->tempLotes)->pluck('id')->filter()->toArray(); // Filtra IDs válidos (excluye false/null)



    $lotesToDelete = array_diff($existingIds, $tempIds);


    foreach ($lotesToDelete as $loteId) {

      if (
        Puja::where('lote_id', $loteId)->exists()
        || CarritoLote::where('lote_id', $loteId)->exists()
        || OrdenLote::where('lote_id', $loteId)->exists()
      ) {
        $this->addError(
          'tieneDatos',
          "El lote ID {$loteId} no puede quitarse del contrato porque ya tuvo actividad."
        );
        return;
      }
    }


    if (!empty($lotesToDelete)) {

      ContratoLote::where('contrato_id', $this->contrato->id)
        ->whereIn('lote_id', $lotesToDelete)
        ->delete();

      Lote::whereIn('id', $lotesToDelete)
        ->update([
          'estado' => LotesEstados::DISPONIBLE,
          'ultimo_contrato' => null,
        ]);
    }

    foreach ($this->tempLotes as $tempLote) {


      if ($tempLote['id']) {




        $contratoLote = ContratoLote::withTrashed()->where('contrato_id', $this->contrato->id)
          ->where('lote_id', $tempLote['id'])
          ->first();

        if ($contratoLote) {


          if ($contratoLote->trashed()) {
            $contratoLote->restore();
            Lote::find($tempLote['id'])->update(['ultimo_contrato' => $this->contrato->id, "estado"  => LotesEstados::ASIGNADO]);
          }


          // info(["INTOOOO" => $tempLote['precio_base']]);
          $contratoLote->update([
            'precio_base' => $tempLote['precio_base'],
            'moneda_id' => $tempLote['moneda_id'],
          ]);
        } else {
          // info("INTOOOO eeeslllllllseeee");
          ContratoLote::create([
            "contrato_id" => $this->contrato->id,
            "lote_id" => $tempLote['id'],
            "precio_base" => $tempLote['precio_base'],
            "moneda_id" => $tempLote['moneda_id'],
          ]);

          Lote::find($tempLote['id'])->update(['ultimo_contrato' => $this->contrato->id, "estado"  => LotesEstados::ASIGNADO]);
        }
      } else {

        $newLote = Lote::create([
          'titulo' => $tempLote['titulo'],
          'descripcion' => $tempLote['descripcion'],
          'valuacion' => $tempLote['valuacion'],
          'comitente_id' => $this->contrato?->comitente_id,
          'ultimo_contrato' => $this->contrato?->id,
          'estado' => LotesEstados::INCOMPLETO,
        ]);

        ContratoLote::create([
          'contrato_id' => $this->contrato->id,
          'lote_id' => $newLote->id,
          'precio_base' => $tempLote['precio_base'],
          'moneda_id' => $tempLote['moneda_id'],
        ]);
      }
    }



    if ($send) {
      $message = "";
      if ($this->new) {
        $message = "Creación";
      } else {
        $message = "Actualización";
      }

      $contratoLotes = ContratoLote::where('contrato_id', $this->contrato->id)->get();
      $data = [
        'message' => $message,
        'lotes' => $contratoLotes,
        'comitente' => $this->contrato->comitente?->nombre . " " . $this->contrato->comitente?->apellido,
        "id" => $this->contrato->id,
        "subasta" => $this->contrato->subasta_id,
        "fecha" => $this->contrato->fecha_firma,
      ];


      if ($this->contrato->comitente?->alias) {
        $mail = $this->contrato->comitente?->alias?->comitente?->mail;
      } else {
        $mail = $this->contrato->comitente?->mail;
      }

      // dd($mail);
      Mail::to($mail)->send(new ContratoEmail($data));
      // Mail::to('axeldavidpaz@gmail.com')->send(new TestEmail($data));
    }


    $this->dispatch('loteCreated');
  }




  public function render()
  {
    return view('livewire.admin.contratos.modal-contrato-lotes');
  }
}
