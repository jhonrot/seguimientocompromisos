<?php

use Illuminate\Database\Seeder;
use App\Estado_seguimiento;

class Estado_seguimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado_seguimiento::create([
            'name' => 'NO INICIADO' 
        ]);

        Estado_seguimiento::create([
            'name' => 'EN CURSO'
        ]);

        Estado_seguimiento::create([
            'name' => 'CUMPLIDO'
        ]);
    }
}
