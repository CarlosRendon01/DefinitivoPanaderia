<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class VentasTableSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ventas = [
            [
                'descripcion' => 'Punto de Venta 1',
                'total' => 300,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Punto de Venta 2',
                'total' => 300,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('ventas')->insert($ventas);
    }
}
