<?php

namespace Database\Seeders;

use App\Models\Personal;
use App\Models\TiposBien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoBienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

      $personals = Personal::take(5)->get();      

        $tipo = [
            [
                'nombre' => 'Pintura',                
                'encargado_id' => $personals->random()->id,                
                'suplente_id' => $personals->random()->id,                
              ],
              [
                'nombre' => 'Escultura',                
                'encargado_id' => $personals->random()->id,                
                'suplente_id' => $personals->random()->id,                
            ],
            [
                'nombre' => 'Vinilo',                
                'encargado_id' => $personals->random()->id,               
                'suplente_id' => $personals->random()->id, 
            ],
            [
                'nombre' => 'Vino',                
                'encargado_id' => $personals->random()->id,
                'suplente_id' => $personals->random()->id, 
            ],            
        ];

        foreach ($tipo as $tipo) {
            TiposBien::create($tipo);
        }
    }
}
