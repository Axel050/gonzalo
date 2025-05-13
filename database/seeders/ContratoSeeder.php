<?php

namespace Database\Seeders;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Lote;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $comitentes = Comitente::take(5)->get();


    for ($i = 0; $i < 5; $i++) {
      Contrato::create([
        'archivo_path' => 'contratos/contrato_' . ($i + 1) . '.pdf',
        'fecha_firma' => now()->subDays(rand(1, 30)),
        'comitente_id' => $comitentes->random()->id,
        'subasta_id' => Subasta::inRandomOrder()->first()->id,
        'descripcion' => "Descripcion test - " . $comitentes->random()->id,
        // 'lote_id' => $lotes->random()->id, 
      ]);
    }
  }
}
