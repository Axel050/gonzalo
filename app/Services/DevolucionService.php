<?php

namespace App\Services;

use App\Enums\LotesEstados;
use App\Models\Devolucion;
use App\Models\Lote;
use Illuminate\Support\Facades\DB;

class DevolucionService
{
    public function crearDevoluciones(int $motivoId, array $lotesIds, ?string $descripcion = null, ?string $fecha = null): ?Devolucion
    {
        return DB::transaction(function () use ($motivoId, $lotesIds, $descripcion, $fecha) {
            $fechaDevolucion = $fecha ?: now()->toDateString();

            $lotes = Lote::whereIn('id', $lotesIds)
                ->where('estado', LotesEstados::STANDBY)
                ->get();

            if ($lotes->isEmpty()) {
                return null;
            }

            $devolucion = Devolucion::create([
                'motivo_id' => $motivoId,
                'lote_id' => $lotes->first()->id, // compatibilidad con estructura existente
                'fecha' => $fechaDevolucion,
                'descripcion' => $descripcion,
                'estado' => 'generada',
            ]);

            foreach ($lotes as $lote) {
                $devolucion->lotes()->syncWithoutDetaching([$lote->id]);

                $lote->estado = LotesEstados::DEVUELTO;
                $lote->save();
            }

            return $devolucion;
        });
    }

    public function anularDevolucion(int $devolucionId): bool
    {
        return DB::transaction(function () use ($devolucionId) {
            $devolucion = Devolucion::lockForUpdate()->findOrFail($devolucionId);

            if ($devolucion->estado === 'anulada') {
                return false;
            }

            $lotes = $devolucion->lotes->count() > 0 
                ? $devolucion->lotes 
                : collect([$devolucion->lote])->filter();

            foreach ($lotes as $lote) {
                // Return to STANDBY since they were in STANDBY when Devolucion was created
                $lote->estado = LotesEstados::STANDBY;
                $lote->save();
            }

            $devolucion->estado = 'anulada';
            $devolucion->save();

            return true;
        });
    }
}
