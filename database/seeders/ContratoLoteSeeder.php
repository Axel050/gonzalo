<?php

namespace Database\Seeders;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use App\Models\Moneda;
use App\Models\Subasta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratoLoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $comitentes = Comitente::all();
    $subastas = Subasta::all();

    if ($comitentes->count() < 3) {
      $this->command->error('Se requieren al menos 3 comitentes en la base de datos.');
      return;
    }

    // Obtener contratos existentes
    $contratos = Contrato::all();

    if ($contratos->isEmpty()) {
      $this->command->info('No hay contratos en la base de datos. Creando contratos...');

      // Crear contratos de ejemplo usando comitentes existentes
      $contratos = [
        Contrato::create([
          'archivo_path' => 'contratos/contrato1.pdf',
          'descripcion' => 'Contrato 1',
          'fecha_firma' => now()->subDays(10),
          'comitente_id' => $comitentes[0]->id,
          'subasta_id' => $subastas->random()->id,
        ]),
        Contrato::create([
          'archivo_path' => 'contratos/contrato2.pdf',
          'descripcion' => 'Contrato 2',
          'fecha_firma' => now()->subDays(5),
          'comitente_id' => $comitentes[1]->id, // Segundo comitente
          'subasta_id' => $subastas->random()->id,
        ]),
        Contrato::create([
          'archivo_path' => 'contratos/contrato3.pdf',
          'descripcion' => 'Contrato 3',
          'fecha_firma' => now(),
          'comitente_id' => $comitentes[2]->id, // Tercer comitente
          'subasta_id' => $subastas->random()->id,
        ]),
      ];
    }

    // Obtener lotes existentes
    $lotes = Lote::all();
    $contratos2 = Contrato::all();
    if ($lotes->isEmpty()) {
      $this->command->info('No hay lotes en la base de datos. Creando 9 lotes...');

      // Crear 9 lotes con comitente_id derivado de contratos
      $lotes = collect([
        Lote::create([
          'titulo' => 'Pintura al óleo',
          'descripcion' => 'Pintura de paisaje',
          'comitente_id' => $contratos[0]->comitente_id, // Comitente 1
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Escultura de mármol',
          'descripcion' => 'Figura clásica',
          'comitente_id' => $contratos[1]->comitente_id, // Comitente 2
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Disco de vinilo',
          'descripcion' => 'Álbum de rock',
          'comitente_id' => $contratos[2]->comitente_id, // Comitente 3
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Jarrón antiguo',
          'descripcion' => 'Jarrón de cerámica',
          'comitente_id' => $contratos[0]->comitente_id, // Comitente 1
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Reloj de pared',
          'descripcion' => 'Reloj antiguo',
          'comitente_id' => $contratos[1]->comitente_id, // Comitente 2
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Collar de perlas',
          'descripcion' => 'Joya de lujo',
          'comitente_id' => $contratos[2]->comitente_id, // Comitente 3
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Mueble vintage',
          'descripcion' => 'Cómoda restaurada',
          'comitente_id' => $contratos[0]->comitente_id, // Comitente 1
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Cámara antigua',
          'descripcion' => 'Cámara de colección',
          'comitente_id' => $contratos[1]->comitente_id, // Comitente 2
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Libro raro',
          'descripcion' => 'Primera edición',
          'comitente_id' => $contratos[2]->comitente_id, // Comitente 3
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
      ]);
    } else {
      $this->command->info('Creando 6 lotes adicionales...');

      // Crear 6 lotes adicionales
      $newLotes = [
        Lote::create([
          'titulo' => 'Jarrón antiguo',
          'descripcion' => 'Jarrón de cerámica',
          'comitente_id' => $contratos[0]->comitente_id, // Comitente 1
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Reloj de pared',
          'descripcion' => 'Reloj antiguo',
          'comitente_id' => $contratos[1]->comitente_id, // Comitente 2
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Collar de perlas',
          'descripcion' => 'Joya de lujo',
          'comitente_id' => $contratos[2]->comitente_id, // Comitente 3
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Mueble vintage',
          'descripcion' => 'Cómoda restaurada',
          'comitente_id' => $contratos[0]->comitente_id, // Comitente 1
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Cámara antigua',
          'descripcion' => 'Cámara de colección',
          'comitente_id' => $contratos[1]->comitente_id, // Comitente 2
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
        Lote::create([
          'titulo' => 'Libro raro',
          'descripcion' => 'Primera edición',
          'comitente_id' => $contratos[2]->comitente_id, // Comitente 3
          'ultimo_contrato' =>  $contratos2->random()->id,
        ]),
      ];
      $lotes = $lotes->merge($newLotes); // Combinar lotes existentes con nuevos
    }

    // Datos de ejemplo para contrato_lotes
    $data = [
      [
        'contrato_id' => $contratos[0]->id, // Contrato 1 (Comitente 1)
        'lote_id' => $lotes[0]->id, // Pintura al óleo (Comitente 1)
        'precio_base' => 6000.00,
      ],
      [
        'contrato_id' => $contratos[0]->id, // Contrato 1 (Comitente 1)
        'lote_id' => $lotes[3]->id, // Jarrón antiguo (Comitente 1)
        'precio_base' => 8000.00,
      ],
      [
        'contrato_id' => $contratos[0]->id, // Contrato 1 (Comitente 1)
        'lote_id' => $lotes[6]->id, // Mueble vintage (Comitente 1)
        'precio_base' => 9000.00,
      ],
      [
        'contrato_id' => $contratos[1]->id, // Contrato 2 (Comitente 2)
        'lote_id' => $lotes[1]->id, // Escultura de mármol (Comitente 2)
        'precio_base' => 15000.00,
      ],
      [
        'contrato_id' => $contratos[1]->id, // Contrato 2 (Comitente 2)
        'lote_id' => $lotes[4]->id, // Reloj de pared (Comitente 2)
        'precio_base' => 12000.00,
      ],
      [
        'contrato_id' => $contratos[1]->id, // Contrato 2 (Comitente 2)
        'lote_id' => $lotes[7]->id, // Cámara antigua (Comitente 2)
        'precio_base' => 11000.00,
      ],
      [
        'contrato_id' => $contratos[2]->id, // Contrato 3 (Comitente 3)
        'lote_id' => $lotes[2]->id, // Disco de vinilo (Comitente 3)
        'precio_base' => 4000.00,
      ],
      [
        'contrato_id' => $contratos[2]->id, // Contrato 3 (Comitente 3)
        'lote_id' => $lotes[5]->id, // Collar de perlas (Comitente 3)
        'precio_base' => 20000.00,
      ],
      [
        'contrato_id' => $contratos[2]->id, // Contrato 3 (Comitente 3)
        'lote_id' => $lotes[8]->id, // Libro raro (Comitente 3)
        'precio_base' => 7000.00,
      ],
    ];

    // Insertar los datos en contrato_lotes
    foreach ($data as $item) {
      ContratoLote::create([
        'contrato_id' => $item['contrato_id'],
        'lote_id' => $item['lote_id'],
        'precio_base' => $item['precio_base'],
        'moneda_id' => Moneda::inRandomOrder()->first()->id,
      ]);
    }

    // Actualizar ultimo_contrato para cada Lote
    foreach ($lotes as $lote) {
      // Encontrar el contrato más reciente asociado al lote en contrato_lotes
      $ultimoContrato = ContratoLote::where('lote_id', $lote->id)
        ->join('contratos', 'contrato_lotes.contrato_id', '=', 'contratos.id')
        ->orderBy('contratos.fecha_firma', 'desc')
        ->value('contrato_lotes.contrato_id');

      // Actualizar el campo ultimo_contrato
      if ($ultimoContrato) {
        $lote->update(['ultimo_contrato' => $ultimoContrato]);
      } else {
        $this->command->warn("Lote ID {$lote->id} no tiene contratos asociados. ultimo_contrato queda como null.");
      }
    }
    $this->command->info('Seeder de ContratoLote ejecutado con éxito!');
  }
}
