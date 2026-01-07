<?php

namespace App\Services;

use App\DTOs\CarritoDTO;
use App\DTOs\PantallaPujasDTO;
use App\Enums\CarritoLoteEstados;
use App\Enums\LotesEstados;
use App\Enums\SubastaEstados;
use App\Events\SubastaEstado;
use App\Models\Adquirente;
use App\Models\Carrito;
use App\Models\Contrato;
use App\Models\Lote;
use App\Models\Subasta;
use App\Models\User;
use Carbon\Carbon;
use DomainException;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class CarritoService
{

  public function agregar(int $adquirenteId, int $loteId): void
  {
    $lote = Lote::find($loteId);
    if (!$lote) {
      throw new ModelNotFoundException('Lote no encontrado');
    }

    $subasta = Subasta::find($lote->ultimoContrato?->subasta_id);
    if (!$subasta) {
      throw new ModelNotFoundException('Subasta no encontrada');
    }


    $adquirente = Adquirente::find($adquirenteId);
    if (!$adquirente) {
      throw new ModelNotFoundException('Adquirente no encontrado');
    }

    if ($lote->comitente?->mail == $adquirente->user?->email) {
      throw new DomainException('No puedes pujar por tu lote');
    }



    if (
      $adquirente?->estado_id != 1 && !$adquirente?->garantia($lote->ultimoContrato?->subasta_id)
    ) {
      throw new DomainException('No puedes participar de esta subata aun');
    }

    if (!in_array($subasta->estado, [SubastaEstados::ACTIVA, SubastaEstados::ENPUJA])) {
      throw new DomainException('La subasta no está activa ni en fase de puja');
    }

    if ($lote->estado !== LotesEstados::EN_SUBASTA) {
      throw new DomainException('Lote no disponible para subasta');
    }

    $contratoLote = $lote->ultimoConLote;
    if (!$contratoLote) {
      throw new DomainException('No hay un contrato activo para este lote');
    }

    if ($contratoLote->tiempo_post_subasta_fin && now()->gt($contratoLote->tiempo_post_subasta_fin)) {
      throw new DomainException('El tiempo de puja extendida ha expirado');
    }

    DB::transaction(function () use ($lote, $subasta, $adquirenteId) {
      $carrito = Carrito::firstOrCreate(
        ['adquirente_id' => $adquirenteId]
      );

      $exists = $carrito->carritoLotes()->where('lote_id', $lote->id)->exists();
      if ($exists) {
        throw new DomainException('El lote ya está en el carrito');
      }

      $carrito->carritoLotes()->create([
        'lote_id' => $lote->id,
        'subasta_id' => $subasta->id,
        'estado' => CarritoLoteEstados::ACTIVO
      ]);
    });
  }



  public function quitar(int $adquirenteId, int $loteId)
  {
    if (!$adquirenteId) {
      throw new InvalidArgumentException('Adquirente no especificado');
    }

    if (!$loteId) {
      throw new InvalidArgumentException('Lote no especificado');
    }


    $lote = Lote::find($loteId);

    $adquirenteEsGanador = $lote?->getPujaFinal()?->adquirente_id == $adquirenteId;

    if ($adquirenteEsGanador) {
      throw new InvalidArgumentException("Tu oferta es la ultima, no puedes quitar.");
    }

    $carrito = Carrito::where('adquirente_id', $adquirenteId)
      ->firstOr(function () {
        throw new ModelNotFoundException("Carrito no encontrado", 404);
      });


    $carritoLote = $carrito->carritoLotes()->where('lote_id', $loteId)
      ->firstOr(function () {
        throw new ModelNotFoundException("Lote  no encontrado en carrito", 404);
      });

    $carritoLote->delete();
  }


  public function obtenerCarritoParaUsuario(int $userId)
  {
    // 1️⃣ Query optimizada con JOINs
    $rows = DB::table('carritos')
      ->join('adquirentes', 'adquirentes.id', '=', 'carritos.adquirente_id')
      ->join('carrito_lotes', 'carrito_lotes.carrito_id', '=', 'carritos.id')

      ->join('lotes', 'lotes.id', '=', 'carrito_lotes.lote_id')

      ->join('contrato_lotes', 'contrato_lotes.lote_id', '=', 'lotes.id')
      ->join('contratos', 'contratos.id', '=', 'contrato_lotes.contrato_id')

      ->join('subastas', 'subastas.id', '=', 'contratos.subasta_id')

      ->join('monedas', 'monedas.id', '=', 'contratos.moneda_id')

      // Última puja (LEFT JOIN)
      ->leftJoin('pujas as p', function ($join) {
        $join->on('p.lote_id', '=', 'lotes.id')
          ->whereRaw('p.id = (
                        SELECT MAX(p2.id)
                        FROM pujas p2
                        WHERE p2.lote_id = lotes.id
                    )');
      })

      ->where('adquirentes.user_id', $userId)
      ->whereIn('carrito_lotes.estado', [
        'activo',
        'adjudicado',
        'en_orden',
        'cerrado',
      ])

      ->select([
        'lotes.id as lote_id',
        'lotes.titulo as lote_titulo',
        'lotes.foto1',

        'subastas.id as subasta_id',
        'subastas.titulo as subasta_titulo',
        'subastas.estado as subasta_estado',
        'subastas.tiempo_post_subasta_fin as fin_post_subasta',

        'contrato_lotes.precio_base',
        'lotes.fraccion_min',

        DB::raw('COALESCE(p.monto, contrato_lotes.precio_base) as oferta_actual'),

        'monedas.signo as signo_moneda',

        DB::raw('CASE WHEN p.adquirente_id = adquirentes.id THEN 1 ELSE 0 END as es_ganador'),
      ])
      ->orderByDesc('carrito_lotes.id')
      ->get();

    // 2️⃣ Mapeo a DTO (🔥 TU CÓDIGO)
    return collect($rows)->map(
      fn($row) =>
      new PantallaPujasDTO(
        id: $row->lote_id,
        titulo: $row->lote_titulo,
        foto: $row->foto1,

        subastaId: $row->subasta_id,
        subastaTitulo: $row->subasta_titulo,
        subastaActiva: $row->subasta_estado === 'activa',
        subastaFinalizada: $row->subasta_estado === 'finalizada',
        tiempoPostSubastaFin: $row->fin_post_subasta,

        precioBase: (float) $row->precio_base,
        ofertaActual: (float) $row->oferta_actual,
        fraccionMin: (float) $row->fraccion_min,

        signoMoneda: $row->signo_moneda,

        esGanador: (bool) $row->es_ganador,
      )
    );
  }


  public function tieneOrdenPendiente(Carrito $carrito): bool
  {
    return $carrito
      ->adquirente
      ->ordens()
      ->where('estado', 'pendiente')
      ->exists();
  }



  public function getLotesDetallados(Adquirente $adquirente): Collection
  {

    $estadoPrioridad = [
      CarritoLoteEstados::ACTIVO     => 0,
      CarritoLoteEstados::EN_ORDEN   => 1,
      CarritoLoteEstados::ADJUDICADO => 2,
      CarritoLoteEstados::CERRADO    => 2,
    ];



    $lotes = $adquirente->carrito->lotesFiltrados()
      ->with([
        'pujas' => fn($q) => $q->orderBy('id', 'desc'),
        'ultimoContrato.subasta',
        'contratoLotes.moneda',
      ])
      ->with([
        'contratoLotes' => function ($q) {
          $q->whereIn(
            'contrato_id',
            Contrato::select('id')
          );
        }
      ])
      ->get();

    return $lotes
      ->map(fn($lote) => PantallaPujasDTO::fromModel($lote, $adquirente->id))

      ->sortBy(fn($dto) => [
        // 1️⃣ Estado primero
        $estadoPrioridad[$dto->estado] ?? 99,

        // 2️⃣ Dentro del mismo estado: no ganador primero
        $dto->esGanador ? 1 : 0,
      ])

      ->values();
  }


  public function getLotesDetallados2(Adquirente $adquirente): Collection
  {
    $lotes = $adquirente->carrito->lotesFiltrados()
      ->with([
        'pujas' => fn($q) => $q->orderBy('id', 'desc'),
        'ultimoContrato.subasta',
        'contratoLotes.moneda',
      ])
      ->with([
        'contratoLotes' => function ($q) {
          $q->whereIn(
            'contrato_id',
            Contrato::select('id')
          );
        }
      ])
      ->get();

    return $lotes->map(fn($lote) => PantallaPujasDTO::fromModel($lote, $adquirente->id));
  }


  public function tieneOrdenesPendientes(Adquirente $adquirente): bool
  {
    return $adquirente->ordenes()->where("estado", "pendiente")->exists();
  }


  public function obtenerResumen(Adquirente $adquirente): CarritoDTO
  {
    // 🔹 Órdenes pendientes con relaciones necesarias
    $ordenes = $adquirente->ordenes()
      ->where('estado', 'pendiente')
      ->with([
        'subasta:id,titulo,envio',

        // OrdenLote → Lote
        'lotes.lote:id,titulo,foto1,ultimo_contrato',

        // 🔥 relaciones necesarias para evitar N+1
        'lotes.lote.contratoActual:id,lote_id,contrato_id,moneda_id',
        'lotes.lote.contratoActual.moneda:id,signo',
        'lotes.lote.ultimaPuja:pujas.id,pujas.lote_id,pujas.monto',
      ])
      ->get();

    if ($ordenes->isEmpty()) {
      return new CarritoDTO([], [], [], 0, 0, 0);
    }

    // 🔹 Garantías pagadas indexadas por subasta
    $garantiasPorSubasta = $adquirente->garantias()
      ->where('estado', 'pagado')
      ->get()
      ->keyBy('subasta_id');

    $ordenesDTO = [];
    $lotesDTO   = [];

    $totalLotes = 0;
    $descuentoGarantias = 0;

    foreach ($ordenes as $orden) {
      $subtotal = 0;

      foreach ($orden->lotes as $ol) {
        $subtotal += $ol->precio_final;
        $totalLotes += $ol->precio_final;

        $lotesDTO[] = [
          'orden_id'     => $orden->id,
          'lote_id'      => $ol->lote->id,
          'titulo'       => $ol->lote->titulo,
          'precio_final' => $ol->precio_final,

          // 👇 usados por las cards
          'foto'         => $ol->lote->foto1,
          'moneda'       => $ol->lote->contratoActual?->moneda?->signo ?? '',
          'monto_actual' => $ol->lote->ultimaPuja?->monto ?? 0,

          // info de subasta (card)
          'subasta_id'   => $orden->subasta_id,
          'subasta'      => $orden->subasta->titulo,
        ];
      }

      // 🔹 Garantía
      $garantiaMonto = 0;

      if ($garantiasPorSubasta->has($orden->subasta_id)) {
        $garantiaMonto = (float) $garantiasPorSubasta[$orden->subasta_id]->monto;
        $descuentoGarantias += $garantiaMonto;
      }

      $envio = (float) ($orden->monto_envio ?? 0);

      $totalOrden = max(
        0,
        $subtotal - $garantiaMonto + $envio
      );

      $ordenesDTO[] = [
        'orden_id'   => $orden->id,
        'estado'     => $orden->estado,

        'subasta_id' => $orden->subasta_id,
        'subasta'    => $orden->subasta->titulo,

        'subtotal'   => $subtotal,
        'envio'      => $envio,

        'garantia'   => $garantiaMonto > 0
          ? ['monto' => $garantiaMonto]
          : null,

        'total'      => $totalOrden,
      ];
    }

    return new CarritoDTO(
      ordenes: $ordenesDTO,
      lotes: $lotesDTO,
      garantias: [], // ya no se usan directamente
      totalLotes: $totalLotes,
      descuentoGarantias: $descuentoGarantias,
      totalCarrito: max(0, $totalLotes - $descuentoGarantias)
    );
  }
}
