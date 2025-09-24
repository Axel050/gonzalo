<?php

namespace Database\Seeders;

use App\Enums\LotesEstados;
use App\Enums\SubastaEstados;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use Illuminate\Database\Seeder;


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
      $numContratos = rand(1, 2); // Por ejemplo, entre 1 y 3 contratos

      if (!$item->foto1) {
        $numContratos = 1;
      }
      // Seleccionar contratos aleatorios sin repetición
      $contratosAsignados = $contratos->random(min($numContratos, $contratos->count()));

      // info(["contratos asfinados" => $contratosAsignados]);
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

      $ultimoContrato = Contrato::where('id', $lote->ultimo_contrato)->value("subasta_id");

      if ($ultimoContrato) {

        // SI ES PROXIMA SUB 
        $sub_id = $lote->ultimoContrato?->subasta_id;
        $sub = Subasta::find($ultimoContrato);

        $estado = match ($sub->estado) {
          SubastaEstados::INACTIVA => LotesEstados::ASIGNADO,
          SubastaEstados::ACTIVA, SubastaEstados::ENPUJA => LotesEstados::EN_SUBASTA,
          SubastaEstados::FINALIZADA => $lote->pujas()->exists()
            ? LotesEstados::VENDIDO
            : ($lote->estado === LotesEstados::STANDBY ? LotesEstados::STANDBY : LotesEstados::DISPONIBLE),
          default => $lote->estado, // si no cambia
        };

        info(["Subasta estado" => $sub->estado]);
        info([" Estado" => $estado]);
        $lote->update(['estado' => $estado]);


        // $lote->update([
        //   'ultimo_contrato' => $ultimoContrato,
        // ]);
      } else {
        $this->command->warn("Lote ID {$lote->id} no tiene contratos asociados. ultimo_contrato queda como null.");
      }
    }

    $this->command->info('Seeder de ContratoLote ejecutado con éxito!');
  }
}
