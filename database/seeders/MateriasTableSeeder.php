<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materias')->insert([
            [
                'nombre' => 'Materia Prima 1',
                'descripcion' => 'Descripción de la materia prima 1',
                'proveedor' => 'Juan',
                'cantidad' => 100,
                'precio' => 50.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad' => 'gramos',
            ],
            [
                'nombre' => 'Materia Prima 2',
                'descripcion' => 'Descripción de la materia prima 2',
                'proveedor' => 'Roberto',
                'cantidad' => 200,
                'precio' => 80.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad' => 'gramos',
            ],
            // Agrega más materias primas según sea necesario
        ]);
    }
}

