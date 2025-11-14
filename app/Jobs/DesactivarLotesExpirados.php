<?php

namespace App\Jobs;

use App\Enums\CarritoLoteEstados;
use App\Enums\LotesEstados;
use App\Enums\SubastaEstados;
use App\Events\SubastaEstado;
use App\Models\Subasta;
use App\Events\SubastaEstadoActualizado;
use App\Mail\OrdenEmail;
use App\Models\CarritoLote;
use App\Models\Orden;
use App\Models\OrdenLote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DesactivarLotesExpirados implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function handle()
  {
    // info("aaaIniciando NEW  job DesactivarLotesExpirados a las " . now()->toDateTimeString());

    try {
      Subasta::whereIn('estado', [SubastaEstados::ACTIVA, SubastaEstados::ENPUJA])
        ->where('fecha_fin', '<=', now())
        ->each(function ($subasta) {
          info("Procesando subasta ID: {$subasta->id}, Título: {$subasta->titulo}, Estado: {$subasta->estado}");

          if (!$subasta->fecha_fin) {
            info("Error: fecha_fin es null para subasta ID: {$subasta->id}");
            return;
          }
          info("Antes  tLotesACT");

          $lotesActualizados = false;
          $lotes = $subasta->lotes()->with([
            'pujas' => fn($query) => $query->where('subasta_id', $subasta->id),
            // 'ultimoConLote' => fn($query) => $query->whereColumn('contrato_lotes.contrato_id', 'lotes.ultimo_contrato')
          ])->where('estado', LotesEstados::EN_SUBASTA) // Solo procesar lotes en subasta
            ->get();

          info("Antes  trans");
          DB::transaction(function () use ($subasta, &$lotesActualizados, $lotes) {
            // info(["IN  trans lotes " => $lotes]);

            foreach ($lotes as $lote) {
              $contratoLote = $lote->ultimoConLote;

              info("Antes HJASSS");
              if (!$contratoLote || $contratoLote->estado !== 'activo') {
                info("NUlllllll");
                continue;
              }
              info("HJASSS");
              $hasPujas = $lote->pujas()->where('subasta_id', $subasta->id)->exists();

              if ($hasPujas && !$contratoLote->tiempo_post_subasta_fin) {
                // Validar tiempo_post_subasta
                if (!is_int($subasta->tiempo_post_subasta) || $subasta->tiempo_post_subasta <= 0) {
                  info("Error: tiempo_post_subasta no es un entero válido para subasta ID: {$subasta->id}, usando valor por defecto (5 minutos)");
                  $minutos = 3;
                } else {
                  $minutos = $subasta->tiempo_post_subasta;
                }

                $nuevoTiempo = $subasta->fecha_fin->addMinutes($minutos);
                $contratoLote->update(['tiempo_post_subasta_fin' => $nuevoTiempo]);
                $lote->update(['estado' => LotesEstados::EN_SUBASTA]);
                info("Asignado tiempo_post_subasta_fin: {$nuevoTiempo} para lote ID: {$lote->id} en subasta ID: {$subasta->id}");
                $lotesActualizados = true;
              } elseif ($hasPujas && $contratoLote->tiempo_post_subasta_fin && now()->gt($contratoLote->tiempo_post_subasta_fin)) {
                // Lote vendido
                info("Desactivando lote ID: {$lote->id} (vendido, tiempo post-subasta expirado: {$contratoLote->tiempo_post_subasta_fin}, nuevo estado: vendido)");
                $contratoLote->update(['estado' => 'inactivo']);
                $lote->update(['estado' => LotesEstados::VENDIDO]);
                $lotesActualizados = true;
              } elseif (!$hasPujas) {
                // Lote no vendido, pasa a standby

                //  VER EN DONDE VUELVO A PONER EN ACTIVO EL CONTRATO LOTE  ,  CREO QUE VA DE ACTIVO - a INACTIVO CUANDO TERMINA LA SUBASTA ; SEBERIA VOLVER A PONERLO ACTIVO CUANDO SE CREE EL NUEVO CONTRATO ; ENTONCES YA SERIA UN NUEVO CONTRATO LO TE; ASI QUE UNA VE Z QUE SE PONE INACTIVO ; NO DEBERIA VOLVER A PONERSE ACTIVO ; YA QUE SE PONE INACTIVO CUANDO SE VENDE , o STANDBY ; Y ENTEONES LOEGO SE CREARA OTRO CONTRATO LOTE y CONTATO 

                info("Desactivando lote ID: {$lote->id} (sin pujas, nuevo estado: standby) en subasta ID: {$subasta->id}");
                $contratoLote->update(['estado' => 'inactivo']);
                $lote->update(['estado' => LotesEstados::STANDBY]);
                $lotesActualizados = true;
              }
            }

            $subasta->refresh();
            $hasActiveLotesWithPujas = $subasta->lotes()
              ->where('estado', LotesEstados::EN_SUBASTA)
              ->whereHas(
                'contratoLotes',
                fn($query) => $query
                  ->where('subasta_id', $subasta->id)
                  ->where('estado', 'activo')
                  ->where(function ($q) {
                    $q->whereNull('tiempo_post_subasta_fin')
                      ->orWhere('tiempo_post_subasta_fin', '>=', now());
                  })
              )
              ->whereHas('pujas', fn($query) => $query->where('subasta_id', $subasta->id))
              ->exists();

            // $hasActiveLotes = $subasta->lotes()->whereHas('ultimoConLote', fn($query) => $query->where('estado', 'activo'))->exists();
            $hasActiveLotes = $subasta->lotes()
              ->where('estado', LotesEstados::EN_SUBASTA)
              ->whereHas(
                'contratoLotes',
                fn($query) => $query
                  ->where('subasta_id', $subasta->id)
                  ->where('estado', 'activo')
              )
              ->exists();


            info("Subasta ID: {$subasta->id} tiene lotes activos con pujas: " . ($hasActiveLotesWithPujas ? 'Sí' : 'No'));
            info("Subasta ID: {$subasta->id} tiene lotes activos: " . ($hasActiveLotes ? 'Sí' : 'No'));

            if ($hasActiveLotesWithPujas && $subasta->estado !== SubastaEstados::ENPUJA) {
              info("Cambiando subasta ID: {$subasta->id} a estado 'enpuja'");
              $subasta->update(['estado' => SubastaEstados::ENPUJA]);
            } elseif (!$hasActiveLotes && $subasta->estado !== 'inactiva') {
              info("Desactivando subasta ID: {$subasta->id}");
              info("ADFFFFFFFF5555");
              $subasta->update(['estado' => SubastaEstados::FINALIZADA]);
              info("ADFFFFFFFF");

              $this->crearOrdenesParaSubastaFinalizada($subasta);
              info("ADFFFFFFF222222222F");
            }
          });

          if ($lotesActualizados || $subasta->wasChanged('estado')) {
            info("Emitiendo evento SubastaEstadoActualizado para subasta ID: {$subasta->id}");
            // event(new SubastaEstadoActualizado($subasta));
            event(new SubastaEstado);
          }
        });

      // info("Finalizado job DesactivarLotesExpirados a las " . now()->toDateTimeString());
    } catch (\Exception $e) {
      info("Error en job DesactivarLotesExpirados: " . $e->getMessage());
      throw $e;
    }
  }


  // MÉTODO ACTUALIZADO: Crea órdenes con descuento = monto de garantía + Actualiza CarritoLote
  private function crearOrdenesParaSubastaFinalizada(Subasta $subasta)
  {
    info("CREARRRRRR");
    // Obtener todos los lotes VENDIDO de esta subasta
    $lotesVendidos = $subasta->lotes()
      ->where('estado', LotesEstados::VENDIDO)
      ->with('pujas') // Para obtener la puja ganadora
      ->get();

    if ($lotesVendidos->isEmpty()) {
      info("No hay lotes vendidos en subasta ID: {$subasta->id}");
      return;
    }

    DB::transaction(function () use ($lotesVendidos, $subasta) {
      // NUEVA LÓGICA: Primero, cerrar todos los CarritoLote de esta subasta (perdedores)
      $carritoLotes = CarritoLote::where('subasta_id', $subasta->id)->get();
      foreach ($carritoLotes as $item) {
        $item->update(['estado' => CarritoLoteEstados::CERRADO]);
      }
      info("Cerrados todos los CarritoLote para subasta ID: {$subasta->id}");

      // Agrupar lotes por adquirente_id (ganador)
      $lotesPorAdquirente = $lotesVendidos->groupBy(function ($lote) use ($subasta) {
        // Puja ganadora: la más reciente por id descendente (usando getPujaFinal)
        $pujaGanadora = $lote->getPujaFinal();

        return $pujaGanadora ? $pujaGanadora->adquirente_id : null;
      })->reject(function ($group, $adquirenteId) {
        return is_null($adquirenteId); // Ignorar si no hay puja
      });

      foreach ($lotesPorAdquirente as $adquirenteId => $lotesDelAdquirente) {
        // Obtener el adquirente
        $adquirente = \App\Models\Adquirente::find($adquirenteId);
        if (!$adquirente) {
          info("Advertencia: Adquirente ID {$adquirenteId} no encontrado");
          continue;
        }

        // NUEVA LÓGICA: Actualizar CarritoLote a 'adjudicado' para los ganadores
        $carritoLotesGanadores = CarritoLote::where('subasta_id', $subasta->id)
          ->whereHas('carrito', fn($q) => $q->where('adquirente_id', $adquirenteId))
          ->whereIn('lote_id', $lotesDelAdquirente->pluck('id'))
          ->get();

        foreach ($carritoLotesGanadores as $item) {
          $pujaFinal = $item->lote->getPujaFinal(); // Obtener la puja final del lote
          if ($pujaFinal && $pujaFinal->adquirente_id === $adquirenteId) {
            $item->update(['estado' => CarritoLoteEstados::ADJUDICADO]);
            info("CarritoLote ID: {$item->id} actualizado a 'adjudicado' para lote ID: {$item->lote_id} (ganador: {$pujaFinal->adquirente_id})");
          }
        }

        // Calcular total (suma de precios finales) - Ajustado para usar puja final
        $total = 0;
        $ordenLotesData = [];
        foreach ($lotesDelAdquirente as $lote) {
          $pujaGanadora = $lote->getPujaFinal(); // Usar el mismo método para consistencia

          if (!$pujaGanadora) {
            info("Advertencia: No se encontró puja final para lote ID: {$lote->id}");
            continue;
          }

          // Si Lote tiene accesor precio_final, úsalo: $precioFinal = $lote->precio_final;
          // De lo contrario, usa monto de la puja final
          $precioFinal = $pujaGanadora->monto;

          $total += $precioFinal;


          $ordenLotesData[] = [
            'orden_id' => null, // Se asignará después
            'lote_id' => $lote->id,
            'precio_final' => $precioFinal,
            'created_at' => now(),
            'updated_at' => now(),
          ];
        }

        if (empty($ordenLotesData)) {
          continue;
        }

        // NUEVA LÓGICA: Descuento = monto de garantía pagada para esta subasta
        $montoDescuento = $adquirente->garantiaMonto($subasta->id); // Retorna int del monto pagado, o 0
        // Opcional: Limitar descuento al total: $montoDescuento = min($montoDescuento, $total);

        // Crear Orden con descuento como monto fijo
        $orden = Orden::create([
          'adquirente_id' => $adquirenteId,
          'subasta_id' => $subasta->id,
          'total' => $total,
          'descuento' => $montoDescuento, // Monto directo de la garantía (ej. 1000)
          'estado' => 'pendiente',
          'monto_envio' => $subasta->envio,
        ]);

        // Asignar orden_id a los datos y crear OrdenLotes
        foreach ($ordenLotesData as &$data) {
          $data['orden_id'] = $orden->id;
        }

        OrdenLote::insert($ordenLotesData);

        // $contratoLotes = ContratoLote::where('contrato_id', $this->contrato->id)->get();
        $dataMail = [
          'message' => "Creación",
          'lotes' => $orden->lotes,
          'adquirente' => $adquirente,
          "orden" => $orden,
          "subasta" => $orden->subasta,
        ];

        info(["data mail JOB " => $dataMail]);
        info(["ANTES MAIL mail JOB "]);

        try {
          Mail::to($adquirente->user?->email)->send(new OrdenEmail($dataMail));
        } catch (\Exception $e) {
          // Log del error para debugging, sin detener el job
          info('Error al enviar OrdenEmail en job DesactivarLotesExpirados: ' . $e->getMessage(), [
            'adquirente_id' => $adquirente->id ?? null,
            'orden_id' => $dataMail['id'] ?? null, // Ajusta según tus datos
            'trace' => $e->getTraceAsString(),
          ]);
          // Opcional: Si quieres notificar de otra forma (ej. Slack, DB flag), agrégalo aquí
          // Pero el job continúa ejecutándose
        }

        info("PASO MAILL  WWWWWW");        // NUEVA LÓGICA: Actualizar CarritoLote a 'en_orden' después de crear la orden
        foreach ($carritoLotesGanadores as $item) {
          $pujaFinal = $item->lote->getPujaFinal();
          if ($pujaFinal && $pujaFinal->adquirente_id === $adquirenteId) {
            $item->update(['estado' => CarritoLoteEstados::EN_ORDEN]);
            info("CarritoLote ID: {$item->id} actualizado a 'en_orden' para lote ID: {$item->lote_id} en orden ID: {$orden->id} (ganador: {$pujaFinal->adquirente_id})");
          }
        }

        $totalNeto = $total - $montoDescuento;
        info("Creada orden ID: {$orden->id} para adquirente ID: {$adquirenteId} con total: {$total}, descuento (garantía): {$montoDescuento}, total neto: {$totalNeto} en subasta ID: {$subasta->id}");
      }
    });
  }
}
