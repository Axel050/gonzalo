<?php

namespace Database\Seeders;

use App\Models\Personal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PersonalSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $personals = [
      [
        'nombre' => 'Ignacion',
        'apellido' => 'Fernández',
        'alias' => 'IFernandez',
        'role_id' => 2,
        'CUIT' => '20-54321678-5',
        'domicilio' => 'Las Heras 345, Mendoza',
        'telefono' => '3456789012',
        'user' => [
          'name' => 'igncacio FernándezP',
          'email' => 'ignacion.fernandez@casablanca.com',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Marta',
        'apellido' => 'García',
        'alias' => 'MGarcia',
        'role_id' => 2,
        'CUIT' => '27-34567890-3',
        'domicilio' => 'Mitre 789, Salta',
        'telefono' => '7890123456',
        'user' => [
          'name' => 'marta GarcíaP',
          'email' => 'marta.garcia@casablanca.com',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Enzo',
        'apellido' => 'Pérez',
        'alias' => 'EPerez',
        'role_id' => 2,
        'CUIT' => '20-98765432-1',
        'domicilio' => 'Roca 123, Tucumán',
        'telefono' => '1239876543',
        'user' => [
          'name' => 'Martín PérezP',
          'email' => 'martin.perez@casablanca.com',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Mirian',
        'apellido' => 'Ramírez',
        'alias' => 'MRamirez',
        'role_id' => 2,
        'CUIT' => '27-87654321-9',
        'domicilio' => 'Corrientes 456, Chaco',
        'telefono' => '4567891234',
        'user' => [
          'name' => 'Mirian RamírezP',
          'email' => 'mirian.ramirez@casablanca.com',
          'password' => bcrypt('12345678'),
        ]
      ],
      [
        'nombre' => 'Lucho',
        'apellido' => 'González',
        'alias' => 'LGonzalez',
        'role_id' => 2,
        'CUIT' => '20-45612378-5',
        'domicilio' => 'Belgrano 890, Formosa',
        'telefono' => '8901234567',
        'user' => [
          'name' => 'Lucho GonzálezP',
          'email' => 'lucho.gonzalez@casablanca.com',
          'password' => bcrypt('12345678'),
        ]
      ]
    ];

    foreach ($personals as $personal) {
      $user = User::create($personal['user']);
      unset($personal['user']);
      $personal['user_id'] = $user->id;
      $p = Personal::create($personal);
      $r = Role::find($p->role_id);
      $user->assignRole($r->name);
    }
  }
}
