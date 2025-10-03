<?php

namespace App\Livewire;

use App\Models\Carrito;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Services\CarritoService;
use App\Services\SubastaService;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Livewire\Attributes\On;
use Livewire\Component;

class DetalleLote extends Component
{
  protected $subastaService;
  public $destacados;
  public $modal_foto;
  // public $modal_foto;
  public $modal_index = 0;

  public $modal_ofertar;


  public $id;
  public $subasta;
  public $lote;
  public $own = false;
  public $adquirente;
  public $base;
  public $ultimaOferta;
  public $pujado;

  public $second = "anda";

  public $lote_id;
  public $subasta_id;

  public $method;

  public $records;

  public $formData;
  public $caracteristicas;

  public $url;

  public $moneda;

  public $inCart;


  // #[On('echo:my-channel.{subasta.id},SubastaEstadoActualizado')]

  #[On('echo:my-channel,PujaRealizada')]
  public function test($event)
  {
    if (isset($event['loteId']) && $this->lote?->id !== $event['loteId']) {
      return;
    }

    $this->ultimaOferta = $event['monto'];
    // $this->ultimaOferta = $this->lote?->getPujaFinal()?->monto;
    $this->lote = Lote::find($this->id);
    $this->dispatch('lotes-updated');
  }

  #[On('echo:my-channel,SubastaEstado')]
  public function reloadLotes()
  {
    $this->lote = Lote::find($this->id);
    $this->dispatch('lotes-updated');
  }



  public function addCarrito(CarritoService $carritoService)
  {
    try {

      $carritoService->agregar(
        $this->adquirente->id,
        $this->lote->id
      );

      $this->inCart = true;

      $this->dispatch(
        'show-message-and-redirect',
        message: 'Agregado a tus lotes con éxito.',
        redirect: route('pantalla-pujas'),
        delay: 2000
      );
    } catch (ModelNotFoundException | InvalidArgumentException | DomainException $e) {
      $this->addError('puja', $e->getMessage());
      info("EERORO ADDD");
    } catch (\Exception $e) {
      info('Error en Livewire::addCarrito', ['exception' => $e]);
      $this->addError('puja', 'Error interno al agregar el lote.');
      info("EERORO ADDD222222222");
    }
  }



  public function loadLotes()
  {
    try {
      info("lotesClass");

      $metodo = match ($this->route) {
        'en_subasta' => 'getLotesActivosDestacados',
        'asignado'   => 'getLotesProximosDestacados',
        default      => 'getLotesPasadosDestacados'
      };

      $this->destacados = $this->subastaService?->{$metodo}($this->subasta)?->toArray();


      // $this->destacados = $this->subastaService?->getLotesActivosDestacados($this->subasta)?->toArray();
      // info(["desss" => $this->destacados]);
      // info(["lotesClass" => $this->destacados]);
      // $this->error = null;
    } catch (\Exception $e) {
      // info(["error" => $this-}>destacados]);
      info(["errorrrr" => $e->getMessage()]);
      $this->destacados = [];
      // $this->error = $e->getMessage();
    }
  }


  public function mount(SubastaService $subastaService)
  {


    $this->subastaService = $subastaService;
    $this->adquirente = auth()->user()?->adquirente;
    $this->lote = Lote::find($this->id);
    $this->base = $this->lote?->precio_base;
    $this->subasta = Subasta::find($this->lote?->ultimoContrato?->subasta_id);

    $this->ultimaOferta = $this->lote?->getPujaFinal()?->monto;

    $this->lote_id = $this->lote->id;
    $this->subasta_id = $this->subasta?->id;



    $this->moneda = $this->lote?->moneda;
    // $this->loadLotes();

    if ($this->moneda) {
      $this->moneda = Moneda::find($this->moneda)->value("signo");
    }
    // info(["monedaaaaaa" => $this->lote?->moneda]);

    // info(["PUJASSS exis"  => $this->lote->pujas()->exists()]);

    // info(["destaco"  => $this->destacados]);



    if ($this->adquirente) {

      $carrito = Carrito::where(
        ['adquirente_id' => $this->adquirente->id, 'estado' => 'activo']
      )->first();

      $exists = false;
      if ($carrito) {
        $exists = $carrito->carritoLo()->where('lote_id', $this->lote->id)->exists();
        info(["aaaaa" => $exists]);
        $this->inCart = $exists;
      }
    }





    // if ($this->lote?->getPujaFinal()?->adquirente_id == $this->adquirente?->id) {
    //   $this->own = true;
    // }


    // <img class="lg:max-h-72 max-h-52 w-auto mx-auto "
    // src="{{ Storage::url('imagenes/lotes/normal/' . $lote->foto1) }}" />


    $this->records = [
      [
        'image' => asset('storage/imagenes/lotes/normal/' . $this->lote->foto1),
        'thumb' => asset('storage/imagenes/lotes/thumbnail/' . $this->lote->foto1),
      ],
      [
        'image' => asset('storage/imagenes/lotes/normal/' . $this->lote->foto2),
        'thumb' => asset('storage/imagenes/lotes/thumbnail/' . $this->lote->foto2),
      ],
      [
        'image' => asset('storage/imagenes/lotes/normal/' . $this->lote->foto3),
        'thumb' => asset('storage/imagenes/lotes/thumbnail/' . $this->lote->foto3),
      ],
      [
        'image' => asset('storage/imagenes/lotes/normal/' . $this->lote->foto4),
        'thumb' => asset('storage/imagenes/lotes/thumbnail/' . $this->lote->foto4),
      ],
    ];


    $fotos = [
      $this->lote->foto1,
      $this->lote->foto2,
      $this->lote->foto3,
      $this->lote->foto4,
    ];

    // Filtrar solo las fotos no vacías
    $this->records = collect($fotos)
      ->filter() // elimina null o strings vacíos
      ->map(fn($foto) => [
        'image' => asset('storage/imagenes/lotes/normal/' . $foto),
        'thumb' => asset('storage/imagenes/lotes/thumbnail/' . $foto),
      ])
      ->values()
      ->toArray();






    // info("caracteristicas");
    $this->caracteristicas =  $this->lote->tipo->caracteristicas()->get();
    // info(["caracteristicas" => $this->caracteristicas->toArray()]);
    $this->formData = [];
    foreach ($this->caracteristicas as $caracteristica) {
      $this->formData[$caracteristica->id] = '';

      // Buscar el valor de la característica en valores_cataracteristicas
      if ($this->lote) {
        $valorCaracteristica = $this->lote->valoresCaracteristicas()
          ->where('caracteristica_id', $caracteristica->id)
          ->first();
        // info(["vañor" => $valorCaracteristica]);
        if ($valorCaracteristica) {
          $this->formData[$caracteristica->id] = $valorCaracteristica->valor;
        }
      }
    }
  }






  public function render()
  {
    return view('livewire.detalle-lote');
  }
}
