<?php

namespace Database\Seeders;

use App\Enums\SubastaEstados;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubastasTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {


    try {
      $subastas = [
        [
          'titulo' => 'cuadros',
          'descripcion' => 'A curated set of 19th-century oak furniture, including a dining table and chairs.',
          'comision' => 15,
          'fecha_inicio' => '2025-11-20 10:00:00',
          'fecha_fin' => '2025-11-22 18:00:00',
          'tiempo_post_subasta' => 2,
          'estado' => 'finalizada',
          'garantia' => 500,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
        [
          'titulo' => 'relojes',
          'descripcion' => 'A rare 1970s Rolex Submariner in excellent condition with original box.',
          'comision' => 20,
          'fecha_inicio' => '2025-06-20 09:00:00',
          'fecha_fin' => '2025-08-20 20:00:00',
          'tiempo_post_subasta' => 2,
          'estado' => 'finalizada',
          'garantia' => 1000,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
        [
          'titulo' => 'varios',
          'descripcion' => 'Abstract acrylic painting by a rising contemporary artist, vibrant colors.',
          'comision' => 15,
          'fecha_inicio' => '2025-08-01 14:00:00',
          'fecha_fin' => '2025-09-01 16:00:00',
          'tiempo_post_subasta' => 2,
          'estado' => 'finalizada',
          'garantia' => 300,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
        [
          'titulo' => 'cuadros 2',
          'descripcion' => 'Fully restored 1965 Ford Mustang, red with white interior, low mileage.',
          'comision' => 20,
          'fecha_inicio' => '2025-08-25 12:00:00',
          'fecha_fin' => '2025-11-25 12:00:00',
          'tiempo_post_subasta' => 3,
          'estado' => 'activa',
          'garantia' => 1500,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
        [
          'titulo' => 'muebles',
          'descripcion' => 'Set of 50 rare coins from the 18th and 19th centuries, certified authentic.',
          'comision' => 20,
          'fecha_inicio' => '2025-08-05 08:00:00',
          'fecha_fin' => '2025-11-05 17:00:00',
          'tiempo_post_subasta' => 2,
          'estado' => 'activa',
          'garantia' => 800,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
        [
          'titulo' => 'vinos',
          'descripcion' => 'Collection of 12 bottles of aged Bordeaux wines from top vineyards.',
          'comision' => 20,
          'fecha_inicio' => '2025-11-18 11:00:00',
          'fecha_fin' => '2025-11-29 19:00:00',
          'tiempo_post_subasta' => 2,
          'estado' => 'inactiva',
          'garantia' => 600,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
        [
          'titulo' => 'discos',
          'descripcion' => 'First edition of a classic novel, signed by the author, in pristine condition.',
          'comision' => 20,
          'fecha_inicio' => '2025-11-15 15:00:00',
          'fecha_fin' => '2025-11-22 15:00:00',
          'tiempo_post_subasta' => 2,
          'estado' => 'inactiva',
          'garantia' => 200,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
        [
          'titulo' => 'esculturas',
          'descripcion' => 'Gold and diamond necklace with matching earrings, crafted by a renowned designer.',
          'comision' => 19,
          'fecha_inicio' => '2025-08-30 13:00:00',
          'fecha_fin' => '2025-11-30 21:00:00',
          'tiempo_post_subasta' => 2,
          'estado' => 'activa',
          'garantia' => 1200,
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ],
      ];

      DB::table('subastas')->insert($subastas);

      echo "8 subastas creadas exitosamente en la tabla 'subastas'.";
    } catch (\Exception $e) {
      echo "Error al crear las subastas: " . $e->getMessage();
    }
  }
}
