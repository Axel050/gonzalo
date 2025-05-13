<?php

namespace Database\Seeders;

use App\Models\Contrato;
use App\Models\ContratoLote;
use App\Models\Lote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratoLoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    // Obtener algunos contratos y lotes existentes
    $contratos = Contrato::all();
    $lotes = Lote::all();

    if ($contratos->isEmpty() || $lotes->isEmpty()) {
      $this->command->info('No hay contratos o lotes en la base de datos. Creando algunos datos básicos...');

      // Crear contratos de ejemplo si no existen
      $contratos = [
        Contrato::create(['archivo_path' => 'contratos/contrato1.pdf', 'descripcion' => 'Contrato 1', 'fecha_firma' => now(), 'comitente_id' => 1]),
        Contrato::create(['archivo_path' => 'contratos/contrato2.pdf', 'descripcion' => 'Contrato 2', 'fecha_firma' => now(), 'comitente_id' => 2]),
        Contrato::create(['archivo_path' => 'contratos/contrato3.pdf', 'descripcion' => 'Contrato 3', 'fecha_firma' => now(), 'comitente_id' => 3]),
      ];

      // Crear lotes de ejemplo si no existen
      $lotes = [
        Lote::create(['titulo' => 'Pintura al óleo', 'descripcion' => 'Pintura de paisaje', 'tipo_bien_id' => 1, 'estado_id' => 1, 'moneda_id' => 1]),
        Lote::create(['titulo' => 'Escultura de mármol', 'descripcion' => 'Figura clásica', 'tipo_bien_id' => 2, 'estado_id' => 1, 'moneda_id' => 1]),
        Lote::create(['titulo' => 'Disco de vinilo', 'descripcion' => 'Álbum de rock', 'tipo_bien_id' => 3, 'estado_id' => 1, 'moneda_id' => 1]),
      ];
    }

    // Datos de ejemplo para contrato_lotes
    $data = [
      ['contrato_id' => $contratos[0]->id, 'lote_id' => $lotes[0]->id, 'precio_base' => 6000.00],
      ['contrato_id' => $contratos[0]->id, 'lote_id' => $lotes[1]->id, 'precio_base' => 15000.00],
      ['contrato_id' => $contratos[1]->id, 'lote_id' => $lotes[2]->id, 'precio_base' => 4000.00],
      ['contrato_id' => $contratos[1]->id, 'lote_id' => $lotes[0]->id, 'precio_base' => 5500.00], // Mismo lote, nuevo contrato
      ['contrato_id' => $contratos[2]->id, 'lote_id' => $lotes[1]->id, 'precio_base' => 14000.00], // Mismo lote, otro contrato
    ];

    // Insertar los datos
    foreach ($data as $item) {
      ContratoLote::create([
        'contrato_id' => $item['contrato_id'],
        'lote_id' => $item['lote_id'],
        'precio_base' => $item['precio_base'],
      ]);
    }

    $this->command->info('Seeder de ContratoLote ejecutado con éxito!');
  }
}
