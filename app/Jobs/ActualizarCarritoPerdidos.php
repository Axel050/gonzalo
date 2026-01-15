<?php

namespace App\Jobs;

use App\Enums\CarritoLoteEstados;
use App\Models\Subasta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ActualizarCarritoPerdidos implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public function handle()
  {



    $updated = DB::table('carrito_lotes')
      ->join('subastas', 'carrito_lotes.subasta_id', '=', 'subastas.id')
      ->where('carrito_lotes.estado', CarritoLoteEstados::CERRADO)
      ->where('subastas.fecha_fin', '<=', now()->subDay())
      ->update([
        'carrito_lotes.estado' => CarritoLoteEstados::PERDIDO,
        'carrito_lotes.updated_at' => now(),
      ]);

    info("ActualizarCarritoLotesPerdidos: {$updated} registros marcados como PERDIDO.");
  }
}
