<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Deposito;
use App\Models\Subasta;
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

        // Crear 10 depósitos de prueba
        for ($i = 0; $i < 10; $i++) {
            Deposito::create([
                'fecha' => now()->subDays(rand(1, 30)), // Fecha aleatoria en los últimos 30 días
                'monto' => rand(10000, 50000), // Monto aleatorio entre 100.00 y 500.00 (en centavos)
                'estado' => ['pendiente', 'aprobado', 'rechazado'][rand(0, 2)], // Estado aleatorio
                'adquirente_id' => $adquirentes->random()->id, // Adquirente aleatorio
                'subasta_id' => $subastas->random()->id, // Subasta aleatoria
            ]);
        }
    }
}
