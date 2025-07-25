<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Subasta;
use App\Services\SubastaService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class DesactivarLotesExpirados implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function handle()
  {
    info("Iniciando job DesactivarLotesExpirados xxxa las " . now()->toDateTimeString());

    $ss = Subasta::find(9);
    info(["estado " => $ss]);
    info(["estado " => $ss->estado == "activo"]);

    try {
      Subasta::where('estado', 'activo')
        ->where('fecha_fin', '<=', now())
        ->each(function ($subasta) {
          info("Procesando subasta ID: {$subasta->id}, Título: {$subasta->titulo}");

          $lotesActualizados = false;
          $lotes = $subasta->lotes()->with(['pujas' => fn($query) => $query->where('subasta_id', $subasta->id), 'contratoLotes' => fn($query) => $query->latest()])->get();

          foreach ($lotes as $lote) {
            $contratoLote = $lote->contratoLotes
              ->where('contrato_id', fn($query) => $query->select('id')->from('contratos')->where('subasta_id', $subasta->id))
              ->first();

            if (!$contratoLote || $contratoLote->estado !== 'activo') {
              continue; // Lote ya inactivo
            }

            $hasPujas = $lote->pujas()->where('subasta_id', $subasta->id)->exists();

            if (!$hasPujas && now()->gte($subasta->fecha_fin)) {
              // Desactivar lotes sin pujas después de fecha_fin
              info("Desactivando lote ID: {$lote->id}   (sin pujas) en subasta ID: {$subasta->id}");
              $contratoLote->update(['estado' => 'inactivo']);
              $lotesActualizados = true;
            } elseif ($hasPujas && !$contratoLote->tiempo_post_subasta_fin && now()->gte($subasta->fecha_fin)) {
              // Asignar tiempo_post_subasta_fin a lotes con pujas antes de fecha_fin
              $nuevoTiempo = $subasta->fecha_fin->addMinutes($subasta->tiempo_post_subasta);
              $contratoLote->update(['tiempo_post_subasta_fin' => $nuevoTiempo]);
              info("Asignado tiempo_post_subasta_fin: {$nuevoTiempo} para lote ID: {$lote->id} en subasta ID: {$subasta->id}");
              $lotesActualizados = true;
            } elseif ($hasPujas && $contratoLote->tiempo_post_subasta_fin && now()->gt($contratoLote->tiempo_post_subasta_fin)) {
              // Desactivar lotes con tiempo_post_subasta_fin expirado
              info("Desactivando lote ID: {$lote->id} (tiempo post-subasta expirado: {$contratoLote->tiempo_post_subasta_fin})");
              $contratoLote->update(['estado' => 'inactivo']);
              $lotesActualizados = true;
            }
          }

          $subasta->refresh();
          $hasActiveLotes = $subasta->lotes()->whereHas('contratoLotes', fn($query) => $query->where('estado', 'activo'))->exists();
          info("Subasta ID: {$subasta->id} tiene lotes activos: " . ($hasActiveLotes ? 'Sí' : 'No'));

          if (!$hasActiveLotes && $subasta->estado === 'activa') {
            info("Desactivando subasta ID: {$subasta->id}");
            $subasta->update(['estado' => 'inactiva']);
          }

          if ($lotesActualizados || $subasta->wasChanged('estado')) {
            info("Emitiendo evento SubastaEstadoActualizado para subasta ID: {$subasta->id}");
            // event(new SubastaEstadoActualizado($subasta));
          }
        });

      info("Finalizado job DesactivarLotesExpirados a las " . now()->toDateTimeString());
    } catch (\Exception $e) {
      info("Error en job DesactivarLotesExpirados: " . $e->getMessage());
      throw $e;
    }
  }
}
