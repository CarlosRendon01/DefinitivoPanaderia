<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Materia;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PedidoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-pedido')->only('index');
        $this->middleware('permission:crear-pedido', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-pedido', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-pedido', ['only' => ['destroy']]);
    }

    public function __invoke()
    {
        return view('pedidos.crear');
    }

    public function generarPDF($id)
    {
        $pedido = Pedido::findOrFail($id);
        $productos = $pedido->productos;

        $pdf = PDF::loadView('pedidos.pdf', [
            'pedido' => $pedido,
            'productos' => $productos,
            'extras' => $pedido->extras,
            'dinero' => $pedido->dinero
        ]);

        return $pdf->download('pedido_' . $pedido->id . '.pdf');
    }

    public function index()
    {
        $pedidos = Pedido::with('productos')->paginate(5);
        return view('pedidos.index', compact('pedidos'));
    }

    public function detalles($id)
    {
        $pedido = Pedido::find($id);
        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        $detalles = $pedido->productos->map(function ($producto) {
            return [
                'producto' => $producto->nombre,
                'cantidad' => $producto->pivot->cantidad,
            ];
        });

        $respuesta = [
            'productos' => $detalles,
            'extras' => $pedido->extras,
            'dinero' => $pedido->dinero
        ];

        return response()->json($respuesta);
    }

    public function create()
    {
        $productos = Producto::all();
        $materiasPrimas = Materia::all();
        return view('pedidos.crear', compact('productos', 'materiasPrimas'));
    }

    public function store(Request $request)
{
    DB::beginTransaction();
    try {
        // Validaciones
        $validated = $request->validate([
            'descripcion' => 'required|string|max:255',
            'total' => 'required|numeric',
            'extras' => 'nullable|string',
            'dinero' => 'nullable|numeric',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|integer|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'materiasPrimas' => 'nullable|array',
            'materiasPrimas.*.id' => 'required|integer|exists:materias,id',
            'materiasPrimas.*.cantidad' => 'required|integer|min:1'
        ]);

        // Recalcular el total basado en los productos
        $total = 0;

        foreach ($request->productos as $producto) {
            $productoModel = Producto::find($producto['id']);
            if ($productoModel) {
                $total += $productoModel->precio * $producto['cantidad'];
            }
        }

        // Sumar el dinero extra si está presente
        if ($request->filled('dinero')) {
            $total += $request->dinero;
        }

        // Crear el pedido
        $pedido = Pedido::create([
            'descripcion' => $request->descripcion,
            'total' => $total,
            'extras' => $request->extras,
            'dinero' => $request->dinero
        ]);

        // Adjuntar productos al pedido
        foreach ($request->productos as $producto) {
            $pedido->productos()->attach($producto['id'], ['cantidad' => $producto['cantidad']]);
            $productoModel = Producto::find($producto['id']);
            if ($productoModel) {
                $productoModel->cantidad -= $producto['cantidad'];
                $productoModel->save();
            }
        }

        // Descontar materias primas si están presentes
        if ($request->filled('materiasPrimas')) {
            foreach ($request->materiasPrimas as $materiaPrima) {
                $materiaPrimaModel = Materia::find($materiaPrima['id']);
                if ($materiaPrimaModel) {
                    $materiaPrimaModel->cantidad -= $materiaPrima['cantidad'];
                    $materiaPrimaModel->save();
                }
            }
        }

        DB::commit();
        return redirect()->route('pedidos.index')->with('success', 'Pedido registrado exitosamente.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollback();
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => 'Error al registrar el pedido: ' . $e->getMessage()])->withInput();
    }
}

    public function edit(Pedido $pedido)
    {
        $productos = Producto::all();
        $materiasPrimas = Materia::all();
        return view('pedidos.editar', compact('pedido', 'productos', 'materiasPrimas'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'extras' => 'nullable|string',
            'dinero' => 'nullable|numeric',
            'productos' => 'required|array',
            'productos.*.cantidad' => 'required|integer|min:1',
            'materiasPrimas' => 'nullable|array',
            'materiasPrimas.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $total = 0;

            foreach ($request->productos as $id => $details) {
                $producto = Producto::findOrFail($id);
                $cantidadOriginal = $pedido->productos()->find($id)->pivot->cantidad;
                $nuevaCantidad = $details['cantidad'];
                $diferenciaCantidad = $nuevaCantidad - $cantidadOriginal;
                $pedido->productos()->updateExistingPivot($id, ['cantidad' => $nuevaCantidad]);
                $total += $producto->precio * $nuevaCantidad;
                $producto->cantidad -= $diferenciaCantidad;
                $producto->save();
            }

            if ($request->filled('materiasPrimas')) {
                foreach ($request->materiasPrimas as $id => $details) {
                    $materiaPrima = Materia::findOrFail($id);
                    $cantidadOriginal = $pedido->materias()->find($id)->pivot->cantidad;
                    $nuevaCantidad = $details['cantidad'];
                    $diferenciaCantidad = $nuevaCantidad - $cantidadOriginal;
                    $materiaPrima->cantidad -= $diferenciaCantidad;
                    $materiaPrima->save();
                }
            }

            $total += $request->dinero;
            $pedido->update([
                'descripcion' => $request->descripcion,
                'total' => $total,
                'extras' => $request->extras,
                'dinero' => $request->dinero
            ]);

            DB::commit();
            return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente.');
    }

    public function finalizar(Request $request, $id)
{
    $pedido = Pedido::findOrFail($id);

    $validated = $request->validate([
        'pago' => 'required|numeric|min:' . ($pedido->total / 2),
    ]);

    $pago = $request->input('pago');
    $cambio = $pago - $pedido->total;

    if ($pago < $pedido->total) {
        return redirect()->back()->withErrors(['error' => 'El pago debe ser igual o mayor al total del pedido.'])
                               ->withInput(['pago' => $pago, 'pedido_id' => $id]);
    }

    DB::beginTransaction();
    try {
        // Crear la venta
        $venta = Venta::create([
            'descripcion' => $pedido->descripcion,
            'total' => $pedido->total,
        ]);

        foreach ($pedido->productos as $producto) {
            $venta->productos()->attach($producto->id, [
                'cantidad' => $producto->pivot->cantidad,
            ]);
        }

        $pedido->delete();

        DB::commit();

        return redirect()->route('pedidos.index')->with('success', "Venta realizada exitosamente. Cambio: $${cambio}");
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->withErrors(['error' => 'Error al finalizar el pedido: ' . $e->getMessage()])
                               ->withInput(['pago' => $pago, 'pedido_id' => $id]);
    }
}

public function dashboard()
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

    return view('dashboard', compact(
        'pedidosHoy',
        'totalPedidos',
        'totalPedidosHoy',
        'totalAcumuladoHoy',
        'totalProductosVendidosHoy'
    ));
}

}