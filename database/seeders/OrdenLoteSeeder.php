<?php

namespace Database\Seeders;

use App\Models\Lote;
use App\Models\Orden;
use App\Models\OrdenLote;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdenLoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {


    $ordenes = Orden::pluck('id')->toArray();
    $lotes = Lote::pluck('id')->toArray();
    $subastas = Subasta::pluck('id')->toArray();

    // Crear 10 orden_lotes con datos existentes
    for ($i = 0; $i < 10; $i++) {
      OrdenLote::create([
        'orden_id' => $ordenes[array_rand($ordenes)],
        'lote_id' => $lotes[array_rand($lotes)],
        'subasta_id' => $subastas[array_rand($subastas)],
        'precio_final' => rand(5000, 30000),
      ]);
    }
  }
}
