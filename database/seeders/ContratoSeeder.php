<?php

namespace Database\Seeders;

use App\Models\Comitente;
use App\Models\Contrato;
use App\Models\Lote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $comitentes = Comitente::take(5)->get();
        // $lotes = Lote::take(5)->get();

        // Crear 5 contratos de prueba
        for ($i = 0; $i < 5; $i++) {
            Contrato::create([
                'archivo_path' => 'contratos/contrato_' . ($i + 1) . '.pdf', 
                'fecha_firma' => now()->subDays(rand(1, 30)),
                'comitente_id' => $comitentes->random()->id,                
                'descripcion' => "Descripcion test - " . $comitentes->random()->id,                
                // 'lote_id' => $lotes->random()->id, 
            ]);
        }
    }
}
