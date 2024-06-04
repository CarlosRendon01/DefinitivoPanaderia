<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = [
            [
                'nombre' => 'Pan Tostado',
                'descripcion' => 'Muy rico',
                'imagen_url' => 'imagenes_productos/SUOGKlfVusgRLYus96fa6xHrIIATWc7YxBxJho19.png',
                'precio' => 10.00,
                'cantidad' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'pan blanco pan pequeño',
                'descripcion' => 'Muy deli',
                'imagen_url' => 'imagenes_productos/tostado.png',
                'precio' => 10.00,
                'cantidad' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('productos')->insert($productos);
    }
}
