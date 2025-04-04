<?php

namespace Database\Seeders;

use App\Models\CondicionIva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CondicionIvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           $condiciones = [
            ['nombre' => 'Responsable Inscripto'],
            ['nombre' => 'Monotributista'],
            ['nombre' => 'Exento'],
            ['nombre' => 'Consumidor Final']
        ];

        foreach ($condiciones as $condicion) {
            CondicionIva::create($condicion);
        }
    }
}
