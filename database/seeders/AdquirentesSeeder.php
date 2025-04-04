<?php

namespace Database\Seeders;

use App\Models\Adquirente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdquirentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $adquirentes = [
            [
                'nombre' => 'Lucas',
                'apellido' => 'Fernández',
                'alias' => 'LFernandez',
                'estado_id' => 1,
                'CUIT' => '20-54321678-5',
                'condicion_iva_id' => 1,
                'domicilio' => 'Las Heras 345, Mendoza',
                'telefono' => '3456789012',
                'comision' => 20.00,
                'user' => [
                    'name' => 'Lucas Fernández',
                    'email' => 'lucas.fernandez@example.com',
                    'password' => bcrypt('password123'),
                ]
            ],
            [
                'nombre' => 'Laura',
                'apellido' => 'García',
                'alias' => 'LGarcia',
                'estado_id' => 2,
                'CUIT' => '27-34567890-3',
                'condicion_iva_id' => 2,
                'domicilio' => 'Mitre 789, Salta',
                'telefono' => '7890123456',
                'comision' => 22.00,
                'user' => [
                    'name' => 'Laura García',
                    'email' => 'laura.garcia@example.com',
                    'password' => bcrypt('password456'),
                ]
            ],
            [
                'nombre' => 'Martín',
                'apellido' => 'Pérez',
                'alias' => 'MPerez',
                'estado_id' => 1,
                'CUIT' => '20-98765432-1',
                'condicion_iva_id' => 3,
                'domicilio' => 'Roca 123, Tucumán',
                'telefono' => '1239876543',
                'comision' => 20.00,
                'user' => [
                    'name' => 'Martín Pérez',
                    'email' => 'martin.perez@example.com',
                    'password' => bcrypt('password789'),
                ]
            ],
            [
                'nombre' => 'Sofía',
                'apellido' => 'Ramírez',
                'alias' => 'SRamirez',
                'estado_id' => 2,
                'CUIT' => '27-87654321-9',
                'condicion_iva_id' => 4,
                'domicilio' => 'Corrientes 456, Chaco',
                'telefono' => '4567891234',
                'comision' => 18.75,
                'user' => [
                    'name' => 'Sofía Ramírez',
                    'email' => 'sofia.ramirez@example.com',
                    'password' => bcrypt('password101'),
                ]
            ],
            [
                'nombre' => 'Pablo',
                'apellido' => 'González',
                'alias' => 'PGonzalez',
                'estado_id' => 1,
                'CUIT' => '20-45612378-5',
                'condicion_iva_id' => 3,
                'domicilio' => 'Belgrano 890, Formosa',
                'telefono' => '8901234567',
                'comision' => 20.00,
                'user' => [
                    'name' => 'Pablo González',
                    'email' => 'pablo.gonzalez@example.com',
                    'password' => bcrypt('12345678'),
                ]
            ]
        ];

        foreach ($adquirentes as $adquirente) {
            $user = User::create($adquirente['user']);
            unset($adquirente['user']);
            $adquirente['user_id'] = $user->id;
            Adquirente::create($adquirente);


            $roles = ['adq guest', 'adquirente'];    
            $randomRole = $roles[array_rand($roles)];

            $user->assignRole($randomRole);
        }
    }
}
