<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array con configuración de roles y sus permisos específicos
        $rolesPermissions = [
            'Admin' => [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16,17,18,18,20,21,22,23,24,25,26,27],
            'Empleado' => [9,19,20,24,25]
        ];

        // Iterar sobre cada rol y sus permisos para crearlos y asignar los permisos
        foreach ($rolesPermissions as $roleName => $permissions) {
            // Creamos el rol
            $role = Role::create(['name' => $roleName]);

            // Asignamos los permisos específicos al rol
            $role->syncPermissions($permissions);
        }
    }
}
