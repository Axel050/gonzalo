<?php

namespace Database\Seeders;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ContratoLoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {





    $lotes = Lote::all();
    $contratos = Contrato::all();



    // foreach ($lotes as $item) {
    //   ContratoLote::updateOrCreate([
    //     'contrato_id' => $item->ultimo_contrato,
    //     'lote_id' => $item->id,
    //     'precio_base' => rand(10, 100)  * 100,
    //     'moneda_id' => Moneda::inRandomOrder()->first()->id,
    //   ]);
    // }

    foreach ($lotes as $item) {
      // Decidir aleatoriamente cuántos contratos tendrá este lote (1 a 3)
      $numContratos = rand(1, 3); // Por ejemplo, entre 1 y 3 contratos

      if (!$item->foto1) {
        $numContratos = 1;
      }
      // Seleccionar contratos aleatorios sin repetición
      $contratosAsignados = $contratos->random(min($numContratos, $contratos->count()));

      info(["contratos asfinados" => $contratosAsignados]);
      // Crear registros en ContratoLote para cada contrato asignado
      foreach ($contratosAsignados as $contrato) {
        ContratoLote::updateOrCreate(
          [
            'contrato_id' => $contrato->id,
            'lote_id' => $item->id,
          ],
          [
            'precio_base' => rand(10, 100) * 100,
            'moneda_id' => Moneda::inRandomOrder()->first()->id,
          ]
        );
      }
    }

    // Actualizar ultimo_contrato para cada Lote
    foreach ($lotes as $lote) {
      // Encontrar el contrato más reciente asociado al lote en contrato_lotes
      $ultimoContrato = ContratoLote::where('lote_id', $lote->id)
        ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
        ->orderBy('contratos.fecha_firma', 'desc')
        ->value('contrato_lotes.contrato_id');

      // Actualizar el campo ultimo_contrato
      if ($ultimoContrato) {
        $lote->update([
          'ultimo_contrato' => $ultimoContrato,
        ]);
      } else {
        $this->command->warn("Lote ID {$lote->id} no tiene contratos asociados. ultimo_contrato queda como null.");
      }
    }

    $this->command->info('Seeder de ContratoLote ejecutado con éxito!');
  }
}
