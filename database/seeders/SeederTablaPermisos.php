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
            'editar-perfil',

            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario',    
            
            'ver-producto',
            'crear-producto',
            'editar-producto',
            'borrar-producto',  

            'ver-materia',
            'crear-materia',
            'editar-materia',
            'borrar-materia',  

            'ver-venta',
            'crear-venta',
            'editar-venta',
            'borrar-venta',   
            
            'ver-pedido',
            'crear-pedido',
            'editar-pedido',
            'borrar-pedido',
        ];        

        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
