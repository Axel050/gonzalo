<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Lote;
use App\Models\Orden;
use App\Models\OrdenLote;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdenSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    $adquirentes = Adquirente::pluck('id')->toArray();

    // Crear 10 órdenes con adquirentes existentes
    // for ($i = 0; $i < 5; $i++) {
    //   Orden::create([
    //     'adquirente_id' => $adquirentes[array_rand($adquirentes)],
    //     'total' => rand(10000, 50000),
    //     'descuento' => rand(0, 5000),
    //     'estado' => collect(['pendiente', 'pagada', 'cancelada'])->random(),
    //   ]);
    // }
  }
}
