<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(ThemeSeeder::class);

        $this->call(PerpageSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(PermissionSeeder::class);

        $this->call(RoleSeeder::class);

        $this->call(AclSeeder::class);

        $this->call(DistritoSeeder::class);

        $this->call(UnidadeSeeder::class);

        $this->call(DistritoUserSeeder::class);

        $this->call(CargoSeeder::class);

        $this->call(CargaHorariaSeeder::class);

        $this->call(FeriasTipoSeeder::class);

        $this->call(LicencaTipoSeeder::class);

        $this->call(CapacitacaoTipoSeeder::class);

        $this->call(OrgaoEmissorSeeder::class);

        $this->call(VinculoTipoSeeder::class);

        $this->call(VinculoSeeder::class);

        $this->call(ProfissionalSeeder::class);

        $this->call(FeriasSeeder::class);

        $this->call(LicencaSeeder::class);

        $this->call(CapacitacaoSeeder::class);
        
        // \App\Models\User::factory(50)->create();

        // \App\Models\Permission::factory(50)->create();

        // \App\Models\Role::factory(50)->create();

        
    }
}
