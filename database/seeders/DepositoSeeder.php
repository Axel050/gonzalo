<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Deposito;
use App\Models\Subasta;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepositoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $adquirentes = Adquirente::take(5)->get();
    $subastas = Subasta::take(5)->get();

    // // Crear 10 depósitos de prueba
    // for ($i = 0; $i < 10; $i++) {
    //   Deposito::create([
    //     'fecha' => now()->subDays(rand(1, 30)), // Fecha aleatoria en los últimos 30 días
    //     'monto' => rand(10000, 50000), // Monto aleatorio entre 100.00 y 500.00 (en centavos)
    //     'estado' => ['pendiente', 'aprobado', 'rechazado', 'devuelto'][rand(0, 2)], // Estado aleatorio
    //     'adquirente_id' => $adquirentes->random()->id, // Adquirente aleatorio
    //     'subasta_id' => $subastas->random()->id, // Subasta aleatoria
    //   ]);
    // }


    // Crear 10 depósitos de prueba
    for ($i = 0; $i < 10; $i++) {
      $fechaDeposito = now()->subDays(rand(1, 30));
      $estado = ['pagado', 'devuelto'][rand(0, 1)];
      $fechaDevolucion = null;

      if ($estado === 'devuelto') {
        // Asegurar que la fecha de devolución sea mayor que la fecha del depósito
        $diasParaSumar = rand(1, 30);
        $fechaDevolucion = (new Carbon($fechaDeposito))->addDays($diasParaSumar);
      }

      Deposito::create([
        'fecha' => $fechaDeposito,
        'monto' => rand(10000, 50000), // Monto aleatorio entre 100.00 y 500.00
        'estado' => $estado,
        'adquirente_id' => $adquirentes->random()->id, // Adquirente aleatorio
        'subasta_id' => $subastas->random()->id, // Subasta aleatoria
        'fecha_devolucion' => $fechaDevolucion, // Campo fecha_devolucion
      ]);
    }
  }
}
