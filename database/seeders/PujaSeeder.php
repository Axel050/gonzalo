<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Puja;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PujaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run()
  {

    DB::table('pujas')->truncate();


    $lotes = Lote::whereIn('estado', ['vendido', 'en_subasta'])
      ->whereNotNull('ultimo_contrato')
      ->get();

    foreach ($lotes as $lote) {
      // Obtener el subasta_id desde el ultimo_contrato
      $subasta_id = $lote->ultimoConLote?->contrato?->subasta_id;

      if (!$subasta_id) {
        continue; // Saltar si no hay subasta asociada
      }

      // Determinar si el lote debe tener pujas según su estado
      $crearPujas = false;
      if ($lote->estado === 'vendido') {
        $crearPujas = true; // Siempre crear pujas para lotes vendidos
      } elseif ($lote->estado === 'en_subasta') {
        // Solo algunos lotes en_subasta tendrán pujas (por ejemplo, 50% de probabilidad)
        $crearPujas = rand(0, 1) === 1;
      }

      if ($crearPujas) {
        // Obtener adquirentes aleatorios
        $numAdquirentes = ($lote->estado === 'vendido') ? rand(1, 5) : rand(0, 5); // Vendido: 1-5, en_subasta: 0-5
        $adquirentes = Adquirente::inRandomOrder()->take($numAdquirentes)->get();

        // Si es vendido y no hay adquirentes, forzar al menos uno
        if ($lote->estado === 'vendido' && $adquirentes->isEmpty()) {
          $adquirentes = Adquirente::inRandomOrder()->take(1)->get();
        }

        // Establecer un monto base inicial
        $monto_base = $lote->ultimoConLote->precio_base ?? rand(100, 1000);

        foreach ($adquirentes as $index => $adquirente) {
          // Incrementar el monto en cada puja (por ejemplo, 10% más cada vez)
          $monto = $monto_base * (1 + ($index * 0.1));

          Puja::create([
            'lote_id' => $lote->id,
            'adquirente_id' => $adquirente->id,
            'subasta_id' => $subasta_id,
            'monto' => round($monto, 2),
            'created_at' => now()->addSeconds($index * 10), // Simular pujas en diferentes momentos
          ]);
        }
      }
    }
  }
}
