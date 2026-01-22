<?php

namespace App\Jobs;

use App\Enums\LotesEstados;
use App\Enums\SubastaEstados;
use App\Models\Subasta;
use App\Events\SubastaEstadoActualizado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ActivarLotes implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function handle()
  {
    // info("Iniciando job ActivarLotes a las " . now()->toDateTimeString());

    try {
      Subasta::where('estado', SubastaEstados::INACTIVA)
        ->where('fecha_inicio', '<=', now())
        ->where('fecha_fin', '>=', now())
        ->each(function ($subasta) {
          // info("Procesando subasta ID: {$subasta->id}, Título: {$subasta->titulo}, Estado: {$subasta->estado}, Fecha inicio: {$subasta->fecha_inicio}");

          if (!$subasta->fecha_inicio || !$subasta->fecha_fin) {
            info("Error: fecha_inicio o fecha_fin es null para subasta ID: {$subasta->id}");
            return;
          }

          $lotesActualizados = false;
          $lotes = $subasta->lotes()
            ->where('estado', LotesEstados::ASIGNADO)
            ->whereHas(
              'contratoLotes',
              fn($query) => $query
                ->where('subasta_id', $subasta->id)
                ->where('estado', 'activo')
            )
            ->get();

          // info("Antes transacción para subasta ID: {$subasta->id}, lotes: " . $lotes->pluck('id')->toJson());

          DB::transaction(function () use ($subasta, &$lotesActualizados, $lotes) {
            // Activar la subasta
            if ($subasta->estado !== SubastaEstados::ACTIVA) {
              info("Cambiando subasta ID: {$subasta->id} a estado 'activa'");
              $subasta->update(['estado' => SubastaEstados::ACTIVA]);
              $lotesActualizados = true;
            }

            // Activar lotes
            foreach ($lotes as $lote) {
              // info("Activando lote ID: {$lote->id} (nuevo estado: ensubasta) en subasta ID: {$subasta->id}");
              $lote->update(['estado' => LotesEstados::EN_SUBASTA]);
              $lotesActualizados = true;
            }
          });

          if ($lotesActualizados) {
            // info("Emitiendo evento SubastaEstadoActualizado para subasta ID: {$subasta->id}");
            event(new SubastaEstadoActualizado($subasta));
          }
        });

      // info("Finalizado job ActivarLotes a las " . now()->toDateTimeString());
    } catch (\Exception $e) {
      info("Error en job ActivarLotes: " . $e->getMessage());
      throw $e;
    }
  }
}
