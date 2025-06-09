<?php

namespace Database\Seeders;

use App\Enums\LotesEstados;
use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Lote;
use App\Models\TiposBien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class LoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    $images = [
      'flower-pot-2730699_1280.png',
      'flower-pots-8033797_1280.png',
      'flowerpots-1852912_1280.png',
      'flowers-5813227_1280.png',
      'hanging-pots-6576645_1280.png',
      'pexels-cottonbro-3778080.png',
      'pots-7118124_1280.png',
      'succulents-2193764_1280.png',
      'windowsill-3565758_1280.png',
    ];




    $lotes = [
      [
        'titulo' => 'Pintura al óleo - Naturaleza',
        // 'numero' => '1',
        'descripcion' => 'Pintura con paisaje de montaña',
        'precio_base' => 6000.00,
        'valuacion' => 12000.00,
        'foto1' => 'pintura_naturaleza_front.jpg',
        'foto2' => 'pintura_naturaleza_back.jpg',
        'foto3' => 'pintura_naturaleza_add1.jpg',
        'fraccion_min' => 5000,

      ],
      [
        'titulo' => 'Escultura clásica',
        // 'numero' => '2',
        'descripcion' => 'Escultura de mármol representando una figura griega',
        'precio_base' => 15000.00,
        'valuacion' => 25000.00,
        'foto1' => 'escultura_clasica_front.jpg',
        'foto2' => 'escultura_clasica_back.jpg',
        'foto3' => 'escultura_clasica_add1.jpg',
        'fraccion_min' => 900,

      ],
      [
        'titulo' => 'Colección de discos de vinilo',
        // 'numero' => '3',
        'descripcion' => 'Set completo de vinilos clásicos de los 80s',
        'precio_base' => 4000.00,
        'valuacion' => 9000.00,
        'foto1' => 'discos_vinilo_front.jpg',
        'foto2' => 'discos_vinilo_back.jpg',
        'foto3' => 'discos_vinilo_add1.jpg',
        'fraccion_min' => 10000,

      ],
      [
        'titulo' => 'Libro de edición especial',
        //  'numero' => '4',
        'descripcion' => 'Edición con cubierta de cuero y detalles dorados',
        'precio_base' => 9500.00,
        'valuacion' => 18000.00,
        'foto1' => 'libro_especial_front.jpg',
        'foto2' => 'libro_especial_back.jpg',
        'foto3' => 'libro_especial_add1.jpg',
        'fraccion_min' => 11000,

      ],
      [
        'titulo' => 'Reloj vintage',
        // 'numero' => '5',
        'descripcion' => 'Reloj de bolsillo con incrustaciones de oro',
        'precio_base' => 14000.00,
        'valuacion' => 22000.00,
        'foto1' => 'reloj_vintage_front.jpg',
        'foto2' => 'reloj_vintage_back.jpg',
        'foto3' => 'reloj_vintage_add1.jpg',
        'fraccion_min' => 2000,

      ],
      [
        'titulo' => 'Colección de ollas',
        // 'numero' => '6',
        'descripcion' => 'Set completo de vinilos clásicos de los 80s',
        'precio_base' => 5000.00,
        'valuacion' => 6000.00,
        'foto1' => 'discos_vinilo_front.jpg',
        'foto2' => 'discos_vinilo_back.jpg',
        'foto3' => 'discos_vinilo_add1.jpg',
        'fraccion_min' => 1000,

      ],
      [
        'titulo' => 'Colección de monedas antiguas',
        //  'numero' => '7',
        'descripcion' => 'Monedas de diversos países del siglo XIX',
        'precio_base' => 4000.00,
        'valuacion' => 4000.00,
        'foto1' => 'monedas_antiguas_front.jpg',
        'foto2' => 'monedas_antiguas_back.jpg',
        'foto3' => 'monedas_antiguas_add1.jpg',
        'fraccion_min' => 500,
      ],

      [
        'titulo' => 'Cuadro abstracto moderno',
        'descripcion' => 'Pintura acrílica con colores vibrantes y formas geométricas',
        'precio_base' => 8000.00,
        'valuacion' => 15000.00,
        'foto1' => 'cuadro_abstracto_front.jpg',
        'foto2' => 'cuadro_abstracto_back.jpg',
        'foto3' => 'cuadro_abstracto_add1.jpg',
        'fraccion_min' => 1000,
      ],
      [
        'titulo' => 'Jarrón de porcelana china',
        'descripcion' => 'Jarrón decorativo de la dinastía Qing con motivos florales',
        'precio_base' => 12000.00,
        'valuacion' => 20000.00,
        'foto1' => 'jarron_porcelana_front.jpg',
        'foto2' => 'jarron_porcelana_back.jpg',
        'foto3' => 'jarron_porcelana_add1.jpg',
        'fraccion_min' => 2000,
      ],
      [
        'titulo' => 'Mueble de caoba antiguo',
        'descripcion' => 'Cómoda victoriana restaurada con detalles tallados',
        'precio_base' => 18000.00,
        'valuacion' => 30000.00,
        'foto1' => 'mueble_caoba_front.jpg',
        'foto2' => 'mueble_caoba_back.jpg',
        'foto3' => 'mueble_caoba_add1.jpg',
        'fraccion_min' => 5000,
      ],
      [
        'titulo' => 'Colección de postales históricas',
        'descripcion' => 'Set de postales de ciudades europeas de principios del siglo XX',
        'precio_base' => 3500.00,
        'valuacion' => 7000.00,
        'foto1' => 'postales_historicas_front.jpg',
        'foto2' => 'postales_historicas_back.jpg',
        'foto3' => 'postales_historicas_add1.jpg',
        'fraccion_min' => 500,
      ],
      [
        'titulo' => 'Lámpara art déco',
        'descripcion' => 'Lámpara de pie con base de bronce y pantalla de vidrio esmerilado',
        'precio_base' => 9000.00,
        'valuacion' => 16000.00,
        'foto1' => 'lampara_art_deco_front.jpg',
        'foto2' => 'lampara_art_deco_back.jpg',
        'foto3' => 'lampara_art_deco_add1.jpg',
        'fraccion_min' => 1500,
      ],
      [
        'titulo' => 'Estatua de bronce',
        'descripcion' => 'Escultura de un caballo al galope, firmada por artista reconocido',
        'precio_base' => 14000.00,
        'valuacion' => 24000.00,
        'foto1' => 'estatua_bronce_front.jpg',
        'foto2' => 'estatua_bronce_back.jpg',
        'foto3' => 'estatua_bronce_add1.jpg',
        'fraccion_min' => 3000,
      ],
      [
        'titulo' => 'Colección de sellos postales',
        'descripcion' => 'Álbum con sellos raros de América Latina, años 1900-1950',
        'precio_base' => 5000.00,
        'valuacion' => 10000.00,
        'foto1' => 'sellos_postales_front.jpg',
        'foto2' => 'sellos_postales_back.jpg',
        'foto3' => 'sellos_postales_add1.jpg',
        'fraccion_min' => 800,
      ],
      [
        'titulo' => 'Espejo barroco',
        'descripcion' => 'Espejo de pared con marco dorado y detalles ornamentales',
        'precio_base' => 11000.00,
        'valuacion' => 19000.00,
        'foto1' => 'espejo_barroco_front.jpg',
        'foto2' => 'espejo_barroco_back.jpg',
        'foto3' => 'espejo_barroco_add1.jpg',
        'fraccion_min' => 2000,
      ],
      [
        'titulo' => 'Reloj de pared antiguo',
        'descripcion' => 'Reloj de péndulo de madera de roble, funcional',
        'precio_base' => 7000.00,
        'valuacion' => 13000.00,
        'foto1' => 'reloj_pared_front.jpg',
        'foto2' => 'reloj_pared_back.jpg',
        'foto3' => 'reloj_pared_add1.jpg',
        'fraccion_min' => 1000,
      ],
      [
        'titulo' => 'Tapiz persa',
        'descripcion' => 'Alfombra tejida a mano con motivos tradicionales',
        'precio_base' => 16000.00,
        'valuacion' => 28000.00,
        'foto1' => 'tapiz_persa_front.jpg',
        'foto2' => 'tapiz_persa_back.jpg',
        'foto3' => 'tapiz_persa_add1.jpg',
        'fraccion_min' => 4000,
      ],

      [
        'titulo' => 'Collar de esmeraldas y diamantes',
        'descripcion' => 'Elegante collar con esmeraldas colombianas y diamantes talla brillante, montado en oro blanco de 18k.',
      ],
      [
        'titulo' => 'Fotografía histórica firmada',
        'descripcion' => 'Rara fotografía en blanco y negro de un evento icónico del siglo XX, firmada por el fotógrafo.',
      ],
      [
        'titulo' => 'Cámara Leica antigua',
        'descripcion' => 'Modelo Leica IIIc de 1940, en excelente estado de conservación y funcional, con estuche original.',
      ],
      [
        'titulo' => 'Botella de vino de colección',
        'descripcion' => 'Vino tinto Gran Reserva de una bodega prestigiosa, añada 1970, conservado en óptimas condiciones.',
      ],
      [
        'titulo' => 'Violín antiguo de luthier',
        'descripcion' => 'Violín europeo del siglo XIX, atribuido a un luthier reconocido, con sonido cálido y potente.',
      ],
    ];

    foreach ($lotes as $lote) {
      Lote::create([
        'titulo' => $lote['titulo'],
        // 'numero' => $lote['numero'],
        'descripcion' => $lote['descripcion'],
        // 'precio_base' => $lote['precio_base'],
        'valuacion' => $lote['valuacion'] ?? 0,
        'foto1' =>  !empty($lote['foto1'])
          ? $images[array_rand($images)]
          : null,
        'foto2' => $lote['foto2'] ?? 0,
        'foto3' => $lote['foto3'] ?? 0,
        'fraccion_min' => $lote['fraccion_min'] ?? 0,
        'tipo_bien_id' =>  !empty($lote['foto1'])
          ? TiposBien::inRandomOrder()->first()->id : null,

        'comitente_id' => Comitente::inRandomOrder()->first()->id,
        'ultimo_contrato' => Contrato::inRandomOrder()->first()->id,
        'estado' => !empty($lote['foto1'])
          ? Arr::random([LotesEstados::DISPONIBLE, LotesEstados::EN_SUBASTA])
          : LotesEstados::INCOMPLETO,
        // 'estado' => !empty($lote['foto1'])
        //   ? Arr::random(array_filter(
        //     LotesEstados::all(),
        //     fn($estado) => $estado !== LotesEstados::INCOMPLETO
        //   ))
        //   : LotesEstados::INCOMPLETO,
        // 'comitente_id' => Comitente::inRandomOrder()->first()->id,
        // 'contrato_id' => Contrato::inRandomOrder()->first()->id ?? 1,
      ]);
    }



    $newLos = Lote::all();

    foreach ($newLos as $key => $value) {
      # code...
    }
  }
}
