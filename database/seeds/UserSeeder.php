<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'gabravo',
            'last_name' => 'bien',
            'type_document' => 1,
            'num_document' => '12345678',
            'state' => 1,
            'state_logic' => 2,
            'email' => 'gabravo.2016@gmail.com',
            'password' => Hash::make('1234567890')
        ])->assignRole('Admin');
    }
}
