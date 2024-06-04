<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario',            
            'ver-ventas',
            'eliminar-ventas',
            'editar-ventas',
            'crear-ventas',
            'ver-productos',
            'crear-producto',
            'editar-producto',
            'eliminar-producto',
        ];        

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
