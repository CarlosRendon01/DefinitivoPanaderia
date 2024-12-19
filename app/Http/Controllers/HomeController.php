<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $hoy = now()->toDateString(); // Fecha de hoy

    // Pedidos del día
    $pedidosHoy = Pedido::whereDate('created_at', $hoy)->with('productos')->get();

    // Contadores
    $totalPedidos = Pedido::count();
    $totalPedidosHoy = $pedidosHoy->count();
    $totalAcumuladoHoy = $pedidosHoy->sum('total');
    $totalProductosVendidosHoy = $pedidosHoy->reduce(function ($carry, $pedido) {
        return $carry + $pedido->productos->sum('pivot.cantidad');
    }, 0);

    return view('home', compact(
        'pedidosHoy',
        'totalPedidos',
        'totalPedidosHoy',
        'totalAcumuladoHoy',
        'totalProductosVendidosHoy'
    ));
}

}
