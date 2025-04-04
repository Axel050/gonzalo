<?php

namespace Database\Seeders;

use App\Models\Moneda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipo = [
            [
                'titulo' => 'Peso',                
            ],
            [
                'titulo' => 'Dolar',                
            ],
            
        ];

        foreach ($tipo as $tipo) {
            Moneda::create($tipo);
        }
    }
}
