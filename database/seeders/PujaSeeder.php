<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Puja;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PujaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run()
  {
    info("RUNNNNNNNNN");
    $lotes = Lote::whereIn('estado', ['vendido', 'en_subasta'])
      ->whereNotNull('ultimo_contrato')
      // ->with(['ultimoConLote.contrato.subasta']) // Cargar la relación ultimoConLote, su contrato y subast
      ->get();

    info(["seedeeeree" => $lotes->toArray()]);
    info("FORRRRR");
    foreach ($lotes as $lote) {
      info("FORRRRRIMNNNNNN");
      // Obtener el subasta_id desde el ultimo_contrato

      $l = Lote::find(4);

      info([
        "casi lote ids" => $lotes->pluck("id"),
        "casi lote 111" => $l->ultimoConLote,
        "casi lote 222" => $l->ultimoConLote->contrato->subasta_id,
      ]);

      // $subasta_id = $lote->ultimoConLote->contrato->subasta_id ?? null;
      $subasta_id = $lote->ultimoConLote?->contrato?->subasta_id;

      info(
        [
          "casi lote id" => $lote->id,
          "casi ote->ultimo_contrato," => $lote->ultimo_contrato,
          "casi ote->ultimoConLote" => $lote->ultimoConLote,
          "casi lote SUBASTA ID  " => $subasta_id,
        ]
      );


      info("zzzzz");
      if (!$subasta_id) {
        continue; // Saltar si no hay subasta asociada
      }

      // Obtener adquirentes aleatorios
      $adquirentes = Adquirente::inRandomOrder()->take(rand(2, 5))->get(); // 2 a 5 adquirentes por lote

      // Establecer un monto base inicial
      $monto_base = $lote->ultimoConLote->precio_base ?? rand(100, 1000); // Usar precio_base o un valor aleatorio

      info("aaaaaaaaaaaxxxxxxxxxxxxxxxxxxxa");
      foreach ($adquirentes as $index => $adquirente) {
        // Incrementar el monto en cada puja (por ejemplo, 10% más cada vez)
        $monto = $monto_base * (1 + ($index * 0.1));
        info("aaaaaaaaaaaaaaaaaaaaa");
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
