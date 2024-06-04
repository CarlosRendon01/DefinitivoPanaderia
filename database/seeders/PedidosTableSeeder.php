<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pedidos = [
            [
                'descripcion' => 'Pedido 1',
                'total' => 300,
                'created_at' => now(),
                'updated_at' => now(),
                'dinero' => 10,
            ],
            [
                'descripcion' => 'Pedido 2',
                'total' => 300,
                'created_at' => now(),
                'updated_at' => now(),
                'dinero' => 10,
            ],
        ];

        DB::table('pedidos')->insert($pedidos);
    }
}
