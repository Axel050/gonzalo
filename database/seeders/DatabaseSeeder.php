<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\EstadosLote;
use App\Models\TiposBien;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        
        $this->call(RoleSeeder::class);

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678'),
        ]);
        
        $user->assignRole("super-admin");

        $this->call(SubastasTableSeeder::class);
        $this->call(EstadoAdquirenteSeeder::class);
        $this->call(CondicionIvaSeeder::class);
        $this->call(ComitentesSeeder::class);
        $this->call(AdquirentesSeeder::class);
        $this->call(AutorizadosSeeder::class);
        $this->call(MonedaSeeder::class);
        // $this->call(DeparatamentoPersonalSeeder::class);
        $this->call(PersonalSeeder::class);
        $this->call(CaracteristicaSeeder::class);
        $this->call(TipoBienSeeder::class);
        $this->call(TipoBienCaracteristicaSeeder::class);
        $this->call(EstadosLoteSeeder::class);
        $this->call(ContratoSeeder::class);
        $this->call(LoteSeeder::class);
        $this->call(ValoresCaracteristicaSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(DevolucionSeeder::class);
        $this->call(FacturaSeeder::class);
        $this->call(DepositoSeeder::class);
        $this->call(PujaSeeder::class);
        $this->call(LoteSubastaSeeder::class);
        $this->call(ContratoLoteSeeder::class);
        


    }
}
