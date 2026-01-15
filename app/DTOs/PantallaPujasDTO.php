<?php

namespace App\DTOs;

use App\Enums\SubastaEstados;
use App\Models\Lote;
use Illuminate\Support\Facades\Storage;
use Livewire\Wireable;

readonly class PantallaPujasDTO implements Wireable
{
  public function __construct(
    public int $id,
    public string $titulo,
    public string $fotoUrl,
    public float $precioBase,
    public float $ofertaActual,
    public float $fraccionMin,
    public string $monedaSigno,
    public bool $esGanador,
    public bool $subastaActiva,
    public ?string $tiempoFinalizacion,
    public int $subastaId,
    public string $subastaTitulo,
    public bool $subastaFinalizada,
    public bool $subastaEnPuja,
    public string $ofertaActualFormateada,
    public string $precioBaseFormateado,
    public bool $tienePujas, // Asegúrate de agregar esta si la usas en el blade
    public string $estado,
    public string $loteEnPuja,
  ) {}

  // Esta función dice cómo convertir el objeto a algo que Livewire entienda (array)
  public function toLivewire()
  {
    return (array) $this;
  }

  // Esta función dice cómo reconstruir el objeto cuando vuelve del frontend
  public static function fromLivewire($value)
  {
    return new self(...$value);
  }

  public static function fromModel(Lote $lote, int $adquirenteId): self
  {


    $contratoLoteActual = $lote->contratoLotes
      ->firstWhere('contrato_id', $lote->ultimo_contrato);



    $ultimaPuja = $lote->pujas->first();
    $montoActual = $ultimaPuja?->monto ?? 0;
    $contrato = $lote->ultimoContrato;
    $subasta = $contrato?->subasta;



    // info(["DTO base " => $contratoLoteActual?->precio_base]);
    // info(["DTO base lote " => $lote]);

    // $fechaFin = $lote->ultimoConLote?->tiempo_post_subasta_fin ?? $subasta?->fecha_fin;
    // $fechaFin = $lote->ultimoConLote?->tiempo_post_subasta_fin ?? $subasta?->fecha_fin;
    $fechaFin = $lote->contratoLoteActual?->tiempo_post_subasta_fin ?? $subasta?->fecha_fin;
    // $fechaFin222 = $lote->ultimoConLote?->tiempo_post_subasta_fin;
    $fechaFin222 = $contratoLoteActual?->tiempo_post_subasta_fin;


    $tiempoPost = $fechaFin222 ? \Carbon\Carbon::parse($fechaFin222)->toDateTimeString() : null;
    $enPuja = ($subasta?->estado === SubastaEstados::ENPUJA);



    return new self(
      id: $lote->id,
      titulo: $lote->titulo,
      fotoUrl: Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1),
      precioBase: (float) ($contratoLoteActual?->precio_base ?? 0),
      ofertaActual: (float) $montoActual,
      fraccionMin: (float) $lote->fraccion_min,
      monedaSigno: $contratoLoteActual?->moneda?->signo ?? '$',
      esGanador: $ultimaPuja?->adquirente_id === $adquirenteId,
      // subastaActiva: $fechaFin ? \Carbon\Carbon::parse($fechaFin222)->gte(now()) : false,
      subastaActiva: $subasta->isActivaCarrito(),
      // tiempoFinalizacion: $fechaFin ? \Carbon\Carbon::parse($fechaFin)->toDateTimeString() : null,
      // tiempoFinalizacion: $fechaFin222 ? \Carbon\Carbon::parse($fechaFin222)->toDateTimeString() : null,
      tiempoFinalizacion: $tiempoPost,

      subastaId: (int) $subasta?->id,
      subastaTitulo: $subasta?->titulo ?? 'N/A',
      subastaFinalizada: ($subasta?->estado === SubastaEstados::FINALIZADA),
      subastaEnPuja: $enPuja,
      loteEnPuja: ($enPuja && $tiempoPost > now()),

      ofertaActualFormateada: number_format($montoActual, 0, ',', '.'),
      // precioBaseFormateado: number_format($lote->ultimoConLote?->precio_base ?? 0, 0, ',', '.'),
      precioBaseFormateado: number_format($contratoLoteActual?->precio_base ?? 0, 0, ',', '.'),
      // precioBaseFormateado: number_format(200 ?? 0, 0, ',', '.'),
      tienePujas: $lote->pujas->count() > 0,
      estado: $lote->pivot->estado,
    );
  }
}
