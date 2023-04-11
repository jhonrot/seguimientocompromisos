<?php

use Illuminate\Database\Seeder;
use App\Organismo;

class OrganismoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organismo::create([
            'name' => 'Organismo 1' 
        ]);
    }
}
