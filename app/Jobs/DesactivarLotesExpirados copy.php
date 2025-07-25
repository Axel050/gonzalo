<?php

namespace App\Jobs;

use App\Models\Subasta;
use App\Events\SubastaEstadoActualizado;
use App\Models\Lote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DesactivarLotesExpirados implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $subastaId = 10;

  public function handle()
  {
    Log::info("Iniciando job DesactivarLotesExpirados para subasta ID: {$this->subastaId} a las " . now()->toDateTimeString());

    try {
      $subasta = Subasta::where('id', $this->subastaId)
        ->whereIn('estado', ['activa', 'enpuja'])
        ->where('fecha_fin', '<=', now())
        ->first();

      if (!$subasta) {
        Log::info("No se encontró subasta con ID: {$this->subastaId} o no cumple con los criterios (activa/enpuja y fecha_fin <= now)");
        return;
      }

      Log::info("Procesando subasta ID: {$subasta->id}, Título: {$subasta->titulo}, Estado: {$subasta->estado}");

      if (!$subasta->fecha_fin) {
        Log::info("Error: fecha_fin es null para subasta ID: {$subasta->id}");
        return;
      }

      $lotesActualizados = false;
      $lotes = $subasta->lotes()->with([
        'pujas' => fn($query) => $query->where('subasta_id', $subasta->id),
      ])->where('estado', 'ensubasta')
        ->get();

      DB::transaction(function () use ($subasta, &$lotesActualizados, $lotes) {
        foreach ($lotes as $lote) {
          $contratoLote = $lote->ultimoConLote;

          if (!$contratoLote || $contratoLote->estado !== 'activo') {
            Log::info("ContratoLote nulo o no activo para lote ID: {$lote->id}");
            continue;
          }

          $hasPujas = $lote->pujas()->where('subasta_id', $subasta->id)->exists();

          if ($hasPujas && !$contratoLote->tiempo_post_subasta_fin) {
            // Validar tiempo_post_subasta
            if (!is_int($subasta->tiempo_post_subasta) || $subasta->tiempo_post_subasta <= 0) {
              Log::info("Error: tiempo_post_subasta no es un entero válido para subasta ID: {$subasta->id}, usando valor por defecto (5 minutos)");
              $minutos = 5;
            } else {
              $minutos = $subasta->tiempo_post_subasta;
            }

            $nuevoTiempo = $subasta->fecha_fin->addMinutes($minutos);
            $contratoLote->update(['tiempo_post_subasta_fin' => $nuevoTiempo]);
            $lote->update(['estado' => 'ensubasta']);
            Log::info("Asignado tiempo_post_subasta_fin: {$nuevoTiempo} para lote ID: {$lote->id} en subasta ID: {$subasta->id}");
            $lotesActualizados = true;
          } elseif ($hasPujas && $contratoLote->tiempo_post_subasta_fin && now()->gt($contratoLote->tiempo_post_subasta_fin)) {
            // Lote vendido
            Log::info("Desactivando lote ID: {$lote->id} (vendido, tiempo post-subasta expirado: {$contratoLote->tiempo_post_subasta_fin}, nuevo estado: vendido)");
            $contratoLote->update(['estado' => 'inactivo']);
            $lote->update(['estado' => 'vendido']);
            $lotesActualizados = true;
          } elseif (!$hasPujas) {
            // Lote no vendido, pasa a standby
            Log::info("Desactivando lote ID: {$lote->id} (sin pujas, nuevo estado: standby) en subasta ID: {$subasta->id}");
            $contratoLote->update(['estado' => 'inactivo']);
            $lote->update(['estado' => 'standby']);
            $lotesActualizados = true;
          }
        }

        $subasta->refresh();
        $hasActiveLotesWithPujas = $subasta->lotes()
          ->where('estado', 'ensubasta')
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

        $hasActiveLotes = $subasta->lotes()
          ->where('estado', 'ensubasta')
          ->whereHas(
            'contratoLotes',
            fn($query) => $query
              ->where('subasta_id', $subasta->id)
              ->where('estado', 'activo')
          )
          ->exists();

        Log::info("Subasta ID: {$subasta->id} tiene lotes activos con pujas: " . ($hasActiveLotesWithPujas ? 'Sí' : 'No'));
        Log::info("Subasta ID: {$subasta->id} tiene lotes activos: " . ($hasActiveLotes ? 'Sí' : 'No'));

        if ($hasActiveLotesWithPujas && $subasta->estado !== 'enpuja') {
          Log::info("Cambiando subasta ID: {$subasta->id} a estado 'enpuja'");
          $subasta->update(['estado' => 'enpuja']);
        } elseif (!$hasActiveLotes && $subasta->estado !== 'inactiva') {
          Log::info("Desactivando subasta ID: {$subasta->id}");
          $subasta->update(['estado' => 'inactiva']);
        }
      });

      if ($lotesActualizados || $subasta->wasChanged('estado')) {
        Log::info("Emitiendo evento SubastaEstadoActualizado para subasta ID: {$subasta->id}");
        // event(new SubastaEstadoActualizado($subasta));
      }

      Log::info("Finalizado job DesactivarLotesExpirados para subasta ID: {$this->subastaId} a las " . now()->toDateTimeString());
    } catch (\Exception $e) {
      Log::error("Error en job DesactivarLotesExpirados para subasta ID: {$this->subastaId}: " . $e->getMessage());
      throw $e;
    }
  }
}
