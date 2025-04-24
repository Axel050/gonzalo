<?php

namespace Database\Seeders;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\EstadosLote;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use App\Models\TiposBien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class LoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {




    $lotes = [
      [
        'titulo' => 'Pintura al óleo - Naturaleza',
        // 'numero' => '1',
        'descripcion' => 'Pintura con paisaje de montaña',
        'precio_base' => 6000.00,
        'valuacion' => 12000.00,
        'foto_front' => 'pintura_naturaleza_front.jpg',
        'foto_back' => 'pintura_naturaleza_back.jpg',
        'foto_add_1' => 'pintura_naturaleza_add1.jpg',
        'fraccion_min' => 5000,

      ],
      [
        'titulo' => 'Escultura clásica',
        // 'numero' => '2',
        'descripcion' => 'Escultura de mármol representando una figura griega',
        'precio_base' => 15000.00,
        'valuacion' => 25000.00,
        'foto_front' => 'escultura_clasica_front.jpg',
        'foto_back' => 'escultura_clasica_back.jpg',
        'foto_add_1' => 'escultura_clasica_add1.jpg',
        'fraccion_min' => 900,

      ],
      [
        'titulo' => 'Colección de discos de vinilo',
        // 'numero' => '3',
        'descripcion' => 'Set completo de vinilos clásicos de los 80s',
        'precio_base' => 4000.00,
        'valuacion' => 9000.00,
        'foto_front' => 'discos_vinilo_front.jpg',
        'foto_back' => 'discos_vinilo_back.jpg',
        'foto_add_1' => 'discos_vinilo_add1.jpg',
        'fraccion_min' => 10000,

      ],
      [
        'titulo' => 'Libro de edición especial',
        //  'numero' => '4',
        'descripcion' => 'Edición con cubierta de cuero y detalles dorados',
        'precio_base' => 9500.00,
        'valuacion' => 18000.00,
        'foto_front' => 'libro_especial_front.jpg',
        'foto_back' => 'libro_especial_back.jpg',
        'foto_add_1' => 'libro_especial_add1.jpg',
        'fraccion_min' => 11000,

      ],
      [
        'titulo' => 'Reloj vintage',
        // 'numero' => '5',
        'descripcion' => 'Reloj de bolsillo con incrustaciones de oro',
        'precio_base' => 14000.00,
        'valuacion' => 22000.00,
        'foto_front' => 'reloj_vintage_front.jpg',
        'foto_back' => 'reloj_vintage_back.jpg',
        'foto_add_1' => 'reloj_vintage_add1.jpg',
        'fraccion_min' => 2000,

      ],
      [
        'titulo' => 'Colección de ollas',
        // 'numero' => '6',
        'descripcion' => 'Set completo de vinilos clásicos de los 80s',
        'precio_base' => 5000.00,
        'valuacion' => 6000.00,
        'foto_front' => 'discos_vinilo_front.jpg',
        'foto_back' => 'discos_vinilo_back.jpg',
        'foto_add_1' => 'discos_vinilo_add1.jpg',
        'fraccion_min' => 1000,

      ],
      [
        'titulo' => 'Colección de monedas antiguas',
        //  'numero' => '7',
        'descripcion' => 'Monedas de diversos países del siglo XIX',
        'precio_base' => 4000.00,
        'valuacion' => 4000.00,
        'foto_front' => 'monedas_antiguas_front.jpg',
        'foto_back' => 'monedas_antiguas_back.jpg',
        'foto_add_1' => 'monedas_antiguas_add1.jpg',
        'fraccion_min' => 500,
      ]
      // Agrega más lotes si lo deseas...
    ];

    foreach ($lotes as $lote) {
      Lote::create([
        'titulo' => $lote['titulo'],
        // 'numero' => $lote['numero'],
        'descripcion' => $lote['descripcion'],
        // 'precio_base' => $lote['precio_base'],
        'valuacion' => $lote['valuacion'],
        'foto_front' => $lote['foto_front'],
        'foto_back' => $lote['foto_back'],
        'foto_add_1' => $lote['foto_add_1'],
        'fraccion_min' => $lote['fraccion_min'],
        'tipo_bien_id' => TiposBien::inRandomOrder()->first()->id,
        'comitente_id' => Comitente::inRandomOrder()->first()->id,
        'moneda_id' => Moneda::inRandomOrder()->first()->id,
        // 'comitente_id' => Comitente::inRandomOrder()->first()->id,
        // 'contrato_id' => Contrato::inRandomOrder()->first()->id ?? 1,
      ]);
    }
  }
}
