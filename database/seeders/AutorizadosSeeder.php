<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\Autorizado;
use App\Models\Comitente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutorizadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $comitente = Comitente::first(); // Obtener el primer comitente
        $adquirente = Adquirente::first(); // Obtener el primer adquirente

        // Insertar autorizados relacionados con un comitente
        Autorizado::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan.perez@example.com',
            'telefono' => '1234567890',
            'dni' => '12345678',
            'comitente_id' => $comitente ? $comitente->id : null,
            'adquirente_id' => null,
        ]);

        Autorizado::create([
            'nombre' => 'Ana',
            'apellido' => 'Lopez',
            'email' => 'ana.lopez@example.com',
            'telefono' => '9876543210',
            'dni' => '34567890',
            'comitente_id' => $comitente ? $comitente->id : null,
            'adquirente_id' => null,
        ]);

        Autorizado::create([
            'nombre' => 'Carlos',
            'apellido' => 'González',
            'email' => 'carlos.gonzalez@example.com',
            'telefono' => '4567890123',
            'dni' => '56789012',
            'comitente_id' => $comitente ? $comitente->id : null,
            'adquirente_id' => null,
        ]);

        // Insertar autorizados relacionados con un adquirente
        Autorizado::create([
            'nombre' => 'Maria',
            'apellido' => 'Gómez',
            'email' => 'maria.gomez@example.com',
            'telefono' => '0987654321',
            'dni' => '87654321',
            'comitente_id' => null,
            'adquirente_id' => $adquirente ? $adquirente->id : null,
        ]);

        Autorizado::create([
            'nombre' => 'Pedro',
            'apellido' => 'Martínez',
            'email' => 'pedro.martinez@example.com',
            'telefono' => '1122334455',
            'dni' => '67890123',
            'comitente_id' => null,
            'adquirente_id' => $adquirente ? $adquirente->id : null,
        ]);

        Autorizado::create([
            'nombre' => 'Sofía',
            'apellido' => 'Ramírez',
            'email' => 'sofia.ramirez@example.com',
            'telefono' => '6677889900',
            'dni' => '78901234',
            'comitente_id' => null,
            'adquirente_id' => $adquirente ? $adquirente->id : null,
        ]);
    }
}
