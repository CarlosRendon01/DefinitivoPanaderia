<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UpdatePermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = User::create([
            'name' => ' Elias',
            'email' => 'eliasrj@gmail.com',
            'password' => bcrypt('abisai145678')
        ]);
    
        $usuario->assignRole('Administrador');
    }
}
