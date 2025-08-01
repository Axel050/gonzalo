<?php

namespace App\Jobs;

use App\Enums\LotesEstados;
use App\Enums\SubastaEstados;
use App\Events\SubastaEstado;
use App\Models\Subasta;
use App\Events\SubastaEstadoActualizado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class DesactivarLotesExpirados implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function handle()
  {
    info("Iniciando NEW  job DesactivarLotesExpirados a las " . now()->toDateTimeString());

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
                  $minutos = 5;
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
              $subasta->update(['estado' => SubastaEstados::FINALIZADA]);
            }
          });

          if ($lotesActualizados || $subasta->wasChanged('estado')) {
            info("Emitiendo evento SubastaEstadoActualizado para subasta ID: {$subasta->id}");
            // event(new SubastaEstadoActualizado($subasta));
            event(new SubastaEstado);
          }
        });

      info("Finalizado job DesactivarLotesExpirados a las " . now()->toDateTimeString());
    } catch (\Exception $e) {
      info("Error en job DesactivarLotesExpirados: " . $e->getMessage());
      throw $e;
    }
  }
}
