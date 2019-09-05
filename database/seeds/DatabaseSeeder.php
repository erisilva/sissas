<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PerpagesTableSeeder::class);
        $this->call(DistritosTableSeeder::class);
        $this->call(UnidadesTableSeeder::class);
        $this->call(CargosTableSeeder::class);
        $this->call(CargaHorariasTableSeeder::class);
        $this->call(VinculosTableSeeder::class);
        $this->call(VinculoTiposTableSeeder::class);
        $this->call(LicencaTiposTableSeeder::class);
        $this->call(FeriasTiposTableSeeder::class);
        $this->call(CapacitacaoTiposTableSeeder::class);
        $this->call(OrgaoEmissorsTableSeeder::class);
        $this->call(HistoricoTiposTableSeeder::class);


        // rodar sempre no fim
        $this->call(AclSeeder::class);
    }
}
