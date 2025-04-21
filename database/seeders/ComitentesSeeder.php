<?php

namespace Database\Seeders;

use App\Models\Comitente;
use App\Models\ComitentesAlias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComitentesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $comitentes = [
      [
        'nombre' => 'Carlos',
        'apellido' => 'Hernández',
        'CUIT' => '20-12345678-9',
        'domicilio' => 'Calle Falsa 123, Buenos Aires',
        'telefono' => '1234567890',
        'mail' => 'carlos.hernandez@example.com',
        'comision' => 20.00,
        'banco' => 'Banco Nación',
        'numero_cuenta' => '123456789',
        'cbu' => '1234567890123456789012',
        'alias_bancario' => 'carlos.hernandez.alias',
        'observaciones' => 'Cliente habitual',
      ],
      [
        'nombre' => 'Marta',
        'apellido' => 'Díaz',
        'CUIT' => '27-98765432-1',
        'domicilio' => 'Avenida Siempreviva 742, Córdoba',
        'telefono' => '9876543210',
        'mail' => 'marta.diaz@example.com',
        'comision' => 18.50,
        'banco' => 'Banco Provincia',
        'numero_cuenta' => '987654321',
        'cbu' => '9876543210987654321098',
        'alias_bancario' => 'marta.diaz.alias',
        'observaciones' => 'Cliente nuevo y en evaluación',
      ],
      [
        'nombre' => 'Pedro',
        'apellido' => 'Ramírez',
        'CUIT' => '20-45678901-2',
        'domicilio' => 'San Martín 456, Rosario',
        'telefono' => '4567890123',
        'mail' => 'pedro.ramirez@example.com',
        'comision' => 20.00,
        'banco' => 'Banco Macro',
        'numero_cuenta' => '456789123',
        'cbu' => '4567891234567890123456',
        'alias_bancario' => 'pedro.ramirez.alias',
        'observaciones' => 'Cliente confiable',
      ],
      [
        'nombre' => 'Lucía',
        'apellido' => 'Gómez',
        'CUIT' => '27-98712345-6',
        'domicilio' => 'Belgrano 678, Mendoza',
        'telefono' => '6789012345',
        'mail' => 'lucia.gomez@example.com',
        'comision' => 19.75,
        'banco' => 'Banco Galicia',
        'numero_cuenta' => '678901234',
        'cbu' => '6789012345678901234567',
        'alias_bancario' => 'lucia.gomez.alias',
        'observaciones' => 'Cliente ocasional',
      ],
      [
        'nombre' => 'Fernando',
        'apellido' => 'Lopez',
        'CUIT' => '20-65432198-7',
        'domicilio' => 'Rivadavia 890, Salta',
        'telefono' => '8901234567',
        'mail' => 'fernando.lopez@example.com',
        'comision' => 20.50,
        'banco' => 'Banco Santander',
        'numero_cuenta' => '890123456',
        'cbu' => '8901234567890123456789',
        'alias_bancario' => 'fernando.lopez.alias',
        'observaciones' => 'Cliente nuevo',
      ]
    ];


    foreach ($comitentes as $comitenteData) {
      // 1. Crear el comitente (sin alias_id)
      $comitente = Comitente::create($comitenteData);

      // 2. Generar alias automático (ej: "CHernandez")
      $nombre = strtoupper($comitente->nombre);
      // $alias = strtoupper(
      //   substr($comitente->nombre, 0, 1) .
      //     preg_replace('/\s+/', '', $comitente->apellido)
      // ;
      $alias =
        substr($nombre, 0, 1) .
        preg_replace('/\s+/', '', $comitente->apellido);

      // 3. Crear el alias asociado
      $aliasModel = ComitentesAlias::create([
        'nombre' => $alias,
        'comitente_id' => $comitente->id
      ]);
      $comitente->update(['alias_id' => $aliasModel->id]);
    }
  }
}
