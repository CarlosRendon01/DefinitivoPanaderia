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
                'nombre' => 'Harina de trigo',
                'descripcion' => 'Harina utilizada en la mayoría de los panes dulces',
                'proveedor' => 'Molinos del Sur',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Azúcar',
                'descripcion' => 'Azúcar blanca para endulzar',
                'proveedor' => 'Dulces del Valle',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Levadura',
                'descripcion' => 'Levadura seca para la fermentación de masas',
                'proveedor' => 'Levaduras Mexicanas',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Mantequilla',
                'descripcion' => 'Mantequilla para darle sabor y textura a los panes',
                'proveedor' => 'Lácteos La Vaca Feliz',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Huevos',
                'descripcion' => 'Huevos frescos para enriquecer las masas',
                'proveedor' => 'Granja El Pollito',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'piezas',
            ],
            [
                'nombre' => 'Leche',
                'descripcion' => 'Leche entera para la preparación de diversos panes',
                'proveedor' => 'Lácteos La Vaca Feliz',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'mililitros',
            ],
            [
                'nombre' => 'Canela',
                'descripcion' => 'Canela molida para aromatizar y dar sabor',
                'proveedor' => 'Especias del Mundo',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Vainilla',
                'descripcion' => 'Extracto de vainilla para dar sabor a los panes',
                'proveedor' => 'Sabores Naturales',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'mililitros',
            ],
            [
                'nombre' => 'Chocolate',
                'descripcion' => 'Chocolate en polvo para saborizar',
                'proveedor' => 'Chocolates La Abuela',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Coco rallado',
                'descripcion' => 'Coco deshidratado para decoración y sabor',
                'proveedor' => 'Tropical Fruits',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Anís',
                'descripcion' => 'Anís en polvo para dar sabor',
                'proveedor' => 'Especias del Mundo',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Piloncillo',
                'descripcion' => 'Panela o piloncillo para endulzar y dar sabor',
                'proveedor' => 'Dulces del Valle',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Fruta seca',
                'descripcion' => 'Mezcla de frutas secas para panes y decoraciones',
                'proveedor' => 'Frutos Secos del Norte',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Mermelada de piña',
                'descripcion' => 'Mermelada para relleno de empanadas',
                'proveedor' => 'Conservas del Sur',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Crema pastelera',
                'descripcion' => 'Crema para rellenos y decoraciones',
                'proveedor' => 'Lácteos La Vaca Feliz',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Harina de maíz',
                'descripcion' => 'Harina utilizada en algunos panes tradicionales',
                'proveedor' => 'Molinos del Sur',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Fécula de maíz',
                'descripcion' => 'Fécula utilizada para dar textura',
                'proveedor' => 'Especias del Mundo',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Nueces',
                'descripcion' => 'Nueces picadas para decoración y sabor',
                'proveedor' => 'Frutos Secos del Norte',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'piezas',
            ],
            [
                'nombre' => 'Almendras',
                'descripcion' => 'Almendras fileteadas para decoración y sabor',
                'proveedor' => 'Frutos Secos del Norte',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'piezas',
            ],
            [
                'nombre' => 'Pasas',
                'descripcion' => 'Pasas para incorporar en las masas',
                'proveedor' => 'Frutos Secos del Norte',
                'cantidad' => 10000,
                'precio' => 2.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'piezas',
            ],
            [
                'nombre' => 'Ajonjolí',
                'descripcion' => 'Semillas de ajonjolí para decoración',
                'proveedor' => 'Especias del Mundo',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Azúcar glas',
                'descripcion' => 'Azúcar pulverizada para decoración',
                'proveedor' => 'Dulces del Valle',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Polvo de hornear',
                'descripcion' => 'Agente leudante para las masas',
                'proveedor' => 'Levaduras Mexicanas',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
            [
                'nombre' => 'Sal',
                'descripcion' => 'Sal fina para dar sabor',
                'proveedor' => 'Especias del Mundo',
                'cantidad' => 10000,
                'precio' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
                'unidad'=> 'gramos',
            ],
        ]);
    }
}

