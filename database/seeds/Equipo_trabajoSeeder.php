<?php

use Illuminate\Database\Seeder;
use App\Equipo_trabajo;

class Equipo_trabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Equipo_trabajo::create([
            'descripcion' => 'EQUIPO 1' 
        ]);
    }
}
