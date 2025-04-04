<?php

namespace Database\Seeders;

use App\Models\DepartamentoPersonal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeparatamentoPersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = [
            ['titulo' => 'Lotes', 'descripcion' => 'desc test'],
            ['titulo' => 'Devoluciones', 'descripcion' => 'desc test'],
            ['titulo' => 'Adquirentes', 'descripcion' => 'desc test'],
            ['titulo' => 'Turnos', 'descripcion' => 'desc test'],
            ['titulo' => 'Estado', 'descripcion' => 'desc test'],
            ['titulo' => 'Valuaciones', 'descripcion' => 'valua'],            
            ['titulo' => 'Encargado', 'descripcion' => 'encarga'],            
        ];

        foreach ($departamentos as $departamento) {
            DepartamentoPersonal::create($departamento);
        }
    }
}
