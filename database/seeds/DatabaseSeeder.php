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
        // $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(Equipo_trabajoSeeder::class);
        $this->call(OrganismoSeeder::class);
        $this->call(Estado_seguimientoSeeder::class);
        $this->call(PrioridadSeeder::class);
        $this->call(ClasificacionSeeder::class);
    }
}
