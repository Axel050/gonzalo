<?php

namespace Database\Seeders;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Models\TiposBien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LoteSeeder extends Seeder
{
  public function run(): void
  {

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // Truncar las tablas
    DB::table('contrato_lotes')->truncate();
    DB::table('carrito_lotes')->truncate();
    DB::table('lotes')->truncate();

    // Rehabilitar claves foráneas
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    $comitentes = Comitente::all();
    $tiposBien  = TiposBien::all();
    $monedas    = Moneda::all();

    // Group contracts by subasta title to ensure consistent numbering
    $subastasConContratos = Subasta::with('contratos')->get()->filter(function ($subasta) {
      return $subasta->contratos->isNotEmpty();
    });

    foreach ($subastasConContratos as $subasta) {
      $subastaTitulo = $subasta->titulo;
      $relatedContratos = $subasta->contratos;

      if ($relatedContratos->isEmpty()) {
        $this->command->warn("Subasta '{$subastaTitulo}' (ID: {$subasta->id}) sin contratos. Saltando...");
        continue;
      }

      // Determine lot state based on subasta state
      $estadoLote = match ($subasta->estado) {
        'activa', 'enpuja' => LotesEstados::EN_SUBASTA,
        'finalizada'       => Arr::random([LotesEstados::DISPONIBLE, 'vendido']),
        'inactiva'         => 'asignado',
        default            => LotesEstados::STANDBY,
      };

      // Reset counter for each unique subasta title
      $numLotes = 4;
      $contador = 1;
      $contador2 = $contador + 1;

      for ($i = 0; $i < $numLotes; $i++) {

        $estadoLote = match ($subasta->estado) {
          'activa', 'enpuja' => LotesEstados::EN_SUBASTA,
          'finalizada'       => Arr::random([LotesEstados::DISPONIBLE, 'vendido']),
          'inactiva'         => 'asignado',
          default            => LotesEstados::STANDBY,
        };

        $titulo = "{$subastaTitulo} {$contador}";
        $imagen = "{$subastaTitulo}{$contador}" . ".jpg";
        $imagen2 = "{$subastaTitulo}{$contador2}" . ".jpg";


        // Pick a random contract from the current subasta's contracts
        $selectedContract = $relatedContratos->random();

        $lote = Lote::create([
          'titulo'          => $titulo,
          'descripcion'     => "Lote {$contador} de la subasta {$subastaTitulo}",
          'valuacion'       => rand(5000, 20000),
          'foto1'           => $imagen,
          'foto2'           => $imagen2,
          'fraccion_min'    => rand(500, 2000),
          'tipo_bien_id'    => $tiposBien->random()->id ?? null,
          'comitente_id'    => $comitentes->random()->id ?? null,
          'ultimo_contrato' => $selectedContract->id, // 🔒 Fixed to a contract of THIS subasta
          'estado'          => $estadoLote,
          'destacado' =>  rand(0, 3) >= 1,
        ]);

        // Pivot coherente: only with the selected contract
        ContratoLote::updateOrCreate(
          ['contrato_id' => $selectedContract->id, 'lote_id' => $lote->id],
          ['precio_base' => rand(1000, 9500), 'moneda_id' => $monedas->random()->id ?? 1]
        );

        $contador++;
      }
    }

    $this->command->info('Lotes creados por subasta, titulados y con estado coherente, con ultimo_contrato correcto.');
  }
}
