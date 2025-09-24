<?php

namespace Database\Seeders;

use App\Enums\LotesEstados;
use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Puja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PujaSeeder extends Seeder
{
  public function run()
  {
    // Limpiar la tabla de pujas antes de generar datos
    DB::table('pujas')->truncate();

    // Tomar todos los lotes con estado disponible o standby
    $lotes = Lote::whereIn('estado', ["disponible", "standby", "vendido"])->get();

    // Aleatoriamente marcar algunos lotes como vendidos
    foreach ($lotes as $lote) {
      if (rand(1, 100) <= 40) { // 40% de probabilidad
        $lote->update(['estado' => LotesEstados::VENDIDO]);
      } else {
        $lote->update([
          'estado' => collect([LotesEstados::DISPONIBLE, LotesEstados::STANDBY])->random()
        ]);
      }
    }

    // Volver a traer los lotes para procesar pujas
    $lotes = Lote::whereIn('estado', ["disponible", "standby", "vendido", "en_subasta"])->get();

    foreach ($lotes as $lote) {
      // Obtener el subasta_id del último contrato-lote
      $subasta_id = $lote->ultimoConLote?->contrato?->subasta_id;

      if (!$subasta_id) {
        continue; // Saltar si no hay subasta asociada
      }

      // Decidir si se crean pujas
      $crearPujas = false;
      if ($lote->estado === LotesEstados::VENDIDO) {
        $crearPujas = true; // Siempre crear pujas para lotes vendidos
      } elseif ($lote->estado === LotesEstados::EN_SUBASTA) {
        $crearPujas = rand(0, 1) === 1; // 50% para lotes en subasta
      }

      if ($crearPujas) {
        // Determinar cuántos adquirentes participarán
        $numAdquirentes = ($lote->estado === LotesEstados::VENDIDO) ? rand(1, 5) : rand(0, 5);
        $adquirentes = Adquirente::inRandomOrder()->take($numAdquirentes)->get();

        // Si es vendido y no hay adquirentes, forzar al menos uno
        if ($lote->estado === LotesEstados::VENDIDO && $adquirentes->isEmpty()) {
          $adquirentes = Adquirente::inRandomOrder()->take(1)->get();
        }

        // Tomar precio base o usar uno aleatorio
        $monto_base = $lote->ultimoConLote->precio_base ?? rand(100, 1000);

        foreach ($adquirentes as $index => $adquirente) {
          // Aumentar cada puja un 10% más
          $monto = $monto_base * (1 + ($index * 0.1));

          Puja::create([
            'lote_id' => $lote->id,
            'adquirente_id' => $adquirente->id,
            'subasta_id' => $subasta_id,
            'monto' => round($monto, 2),
            'created_at' => now()->addSeconds($index * 10),
          ]);
        }
      }
    }

    $this->command->info("Pujas generadas correctamente.");
  }
}
