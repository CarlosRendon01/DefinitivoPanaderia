<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creamos el usuario administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin12345'), // Aseguramos la contraseña con bcrypt
        ]);

        // Asignamos el rol 'Admin' al usuario administrador
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $admin->assignRole($adminRole);
        }

        // Creamos otro usuario
        $user = User::create([
            'name' => 'Empleado1',
            'email' => 'abisai@gmail.com',
            'password' => bcrypt('abisai1456'), // Aseguramos la contraseña con bcrypt
        ]);

        // Asignamos el rol 'Secretaria' al otro usuario
        $secretaryRole = Role::where('name', 'Empleado')->first();
        if ($secretaryRole) {
            $user->assignRole($secretaryRole);
        }
    }
}
