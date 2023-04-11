<?php

use Illuminate\Database\Seeder;
use App\Prioridad;

class PrioridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prioridad::create([
            'name' => 'BAJA' 
        ]);

        Prioridad::create([
            'name' => 'NORMAL'
        ]);

        Prioridad::create([
            'name' => 'ALTA'
        ]);
    }
}
