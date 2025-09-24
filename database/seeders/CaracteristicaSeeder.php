<?php

namespace Database\Seeders;

use App\Models\Caracteristica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaracteristicaSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $caracteristicas = [
      ['nombre' => 'Autor', 'tipo' => 'text'],
      ['nombre' => 'Artista', 'tipo' => 'text'],
      ['nombre' => 'Medidas', 'tipo' => 'text'],
      ['nombre' => 'Estado', 'tipo' => 'text'],
      ['nombre' => 'Audio', 'tipo' => 'file'],
      ['nombre' => 'Época', 'tipo' => 'text'],
      ['nombre' => 'Firma', 'tipo' => 'text'],
      ['nombre' => 'Técnica', 'tipo' => 'text'],
      ['nombre' => 'Material', 'tipo' => 'text'],
      ['nombre' => 'Peso', 'tipo' => 'text'],
      ['nombre' => 'Editorial', 'tipo' => 'text'],
      ['nombre' => 'Año de publicación', 'tipo' => 'text'],
      ['nombre' => 'ISBN', 'tipo' => 'text'],
      ['nombre' => 'Descripción', 'tipo' => 'text'],
    ];

    foreach ($caracteristicas as $caracteristica) {
      Caracteristica::create($caracteristica);
    }
  }
}
