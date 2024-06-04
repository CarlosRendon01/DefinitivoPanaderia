<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF; // Usa el alias registrado
use Carbon\Carbon;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(6);

        return view('productos.index', compact('productos'));
    }

    public function listarTodos()
    {
        $todosLosProductos = Producto::all();
        return view('productos.cargar', compact('todosLosProductos'));
    }
    

    public function restantes()
{
    $fechaHoy = Carbon::today();
    $productos = Producto::whereDate('updated_at', $fechaHoy)
                         ->where('cantidad', '>', 0)
                         ->get();

    $totalInventario = $productos->reduce(function ($carry, $producto) {
        return $carry + ($producto->precio * $producto->cantidad);
    }, 0);

    $pdf = PDF::loadView('productos.restantes', [
        'productos' => $productos,
        'totalInventario' => $totalInventario,
        'fecha' => $fechaHoy->toDateString()
    ]);

    return $pdf->download('productos_restantes_del_dia_' . $fechaHoy->format('Y-m-d') . '.pdf');
}

    public function showChargeForm()
    {
        $productos = Producto::all();
        return view('productos.cargar', compact('productos'));
    }

    public function charge(Request $request)
    {
        $cantidades = $request->input('cantidades', []);
    DB::beginTransaction();
    try {
        foreach ($cantidades as $productoId => $cantidad) {
            if ($cantidad <= 0) continue; // Ignorar valores no positivos

            $producto = Producto::with('materias')->findOrFail($productoId); // Asegurar que el producto existe y cargar sus materias primas
            
            // Revisar si hay suficientes materias primas para la cantidad del producto a cargar
            foreach ($producto->materias as $materia) {
                $cantidadNecesaria = $materia->pivot->cantidad * $cantidad;
                if ($materia->cantidad < $cantidadNecesaria) {
                    throw new \Exception("No hay suficiente {$materia->nombre} para cargar {$cantidad} unidades de {$producto->nombre}");
                }
            }

            // Reducir las materias primas necesarias
            foreach ($producto->materias as $materia) {
                $cantidadNecesaria = $materia->pivot->cantidad * $cantidad;
                $materia->decrement('cantidad', $cantidadNecesaria);
            }

            // Aumentar el stock del producto
            $producto->increment('cantidad', $cantidad);
        }
        DB::commit();
        return redirect()->back()->with('success', 'Cantidades actualizadas correctamente.');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
    }

    public function create()
    {
        $materiasPrimas = Materia::all();
        return view('productos.crear', compact('materiasPrimas'));
    }

    public function store(Request $request)
{
    // Validación
    $request->validate([
        'nombre' => 'required|unique:productos,nombre|string|max:255',
        'descripcion' => 'required|string',
        'cantidad' => 'required|integer|min:1',
        'materias_primas' => 'required|array|min:1',
        'materias_primas.*' => 'exists:materias,id',
        'cantidades' => 'required|array|size:' . count($request->input('materias_primas', [])),
        'cantidades.*' => 'numeric|min:1',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'materias_primas.required' => 'Debe seleccionar al menos una materia prima.',
        'materias_primas.*.exists' => 'La materia prima seleccionada no existe.',
        'cantidades.*.min' => 'La cantidad debe ser al menos 1.',
        'cantidades.required' => 'Debe ingresar una cantidad para cada materia prima.',
        'cantidades.size' => 'La cantidad de elementos en cantidades debe coincidir con el número de materias primas.',
    ]);

    // Manejo de la imagen
    $imagenUrl = null;
    if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen');
        $imagenUrl = $imagen->store('imagenes_productos', 'public');
    }
    

    // Obtener materias primas y cantidades
    $materiasPrimas = $request->input('materias_primas', []);
    $cantidades = $request->input('cantidades', []);
    $cantidadProducto = $request->cantidad;

    DB::beginTransaction();

    try {
        $precioTotalMateriasPrimas = 0;

        foreach ($materiasPrimas as $index => $materiaPrimaId) {
            $materiaPrima = Materia::find($materiaPrimaId);
            $cantidadNecesaria = $cantidades[$index] * $cantidadProducto;

            if ($materiaPrima->cantidad < $cantidadNecesaria) {
                DB::rollback();
                return redirect()->back()->withErrors([
                    'cantidad' => 'No hay suficiente materia prima "' . $materiaPrima->nombre . '" para crear este producto.'
                ])->withInput();
            }

            $precioTotalMateriasPrimas += $materiaPrima->precio * $cantidades[$index];
        }

        // Calcular el precio del producto (sumando el 50%)
        $precioProducto = $precioTotalMateriasPrimas * 1.5;

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $precioProducto,
            'cantidad' => $cantidadProducto,
            'imagen_url' => $imagenUrl,
        ]);

        // Adjuntar materias primas y descontar cantidades
        foreach ($materiasPrimas as $index => $materiaPrimaId) {
            $materiaPrima = Materia::find($materiaPrimaId);
            $cantidadNecesaria = $cantidades[$index] * $cantidadProducto;

            $producto->materias()->attach([
                $materiaPrimaId => ['cantidad' => $cantidades[$index]]
            ]);

            $materiaPrima->cantidad -= $cantidadNecesaria;
            $materiaPrima->save();
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => 'Ocurrió un error al crear el producto: ' . $e->getMessage()])->withInput();
    }

    return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
}


    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $materias = Materia::all(); 
        return view('productos.editar', compact('producto', 'materias'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
    
        $request->validate([
            'nombre' => 'required|unique:productos,nombre|string|max:255',
            'descripcion' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'materias_primas' => 'required|array|min:1',
            'materias_primas.*' => 'exists:materias,id',
            'cantidades' => 'required|array|size:' . count($request->input('materias_primas', [])),
            'cantidades.*' => 'numeric|min:1',
        ], [
            'materias_primas.required' => 'Debe seleccionar al menos una materia prima.',
            'cantidades.required' => 'Debe ingresar una cantidad para cada materia prima seleccionada.',
            'cantidades.size' => 'La cantidad de elementos en cantidades debe coincidir con el número de materias primas seleccionadas.',
        ]);
    
        DB::beginTransaction();
        try {
            if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                if ($producto->imagen_url) {
                    Storage::disk('public')->delete($producto->imagen_url);
                }
                $producto->imagen_url = $request->file('imagen')->store('imagenes_productos', 'public');
            }
    
            // Calcular el nuevo precio basado en las materias primas y sus cantidades
            $precioTotalMateriasPrimas = 0;
            foreach ($request->input('materias_primas', []) as $index => $materiaPrimaId) {
                $cantidad = $request->cantidades[$index];
                $materiaPrima = Materia::findOrFail($materiaPrimaId);
                $precioTotalMateriasPrimas += $materiaPrima->precio * $cantidad;
            }
            $nuevoPrecioProducto = $precioTotalMateriasPrimas * 1.5;
    
            // Actualizar el producto con el nuevo precio
            $producto->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'cantidad' => $request->cantidad,
                'precio' => $nuevoPrecioProducto,
            ]);
    
            // Actualizar las materias primas del producto
            $producto->materias()->sync([]);
            foreach ($request->input('materias_primas', []) as $index => $materiaPrimaId) {
                $cantidad = $request->cantidades[$index];
                $producto->materias()->attach($materiaPrimaId, ['cantidad' => $cantidad]);
            }
    
            DB::commit();
            return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al actualizar el producto: ' . $e->getMessage()])->withInput();
        }
    }
    

private function handleImageUpload(Request $request, Producto $producto)
{
    if ($request->hasFile('imagen')) {
        $imagenUrl = $request->file('imagen')->store('imagenes_productos', 'public');
        $producto->imagen_url = $imagenUrl;
    }
}

private function handleMateriasPrimas(Request $request, Producto $producto)
{
    $materiasPrimas = $request->input('materias_primas');
    $cantidades = $request->input('cantidades');

    $producto->materias()->detach();
    foreach ($materiasPrimas as $index => $materiaPrimaId) {
        $materiaPrima = Materia::findOrFail($materiaPrimaId);
        $cantidadNecesaria = $cantidades[$index];

        if ($materiaPrima->cantidad < $cantidadNecesaria) {
            throw new \Exception("Insufficient quantity for " . $materiaPrima->nombre);
        }

        $producto->materias()->attach($materiaPrimaId, ['cantidad' => $cantidadNecesaria]);
        $materiaPrima->decrement('cantidad', $cantidadNecesaria);
    }
}




    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);

            // Eliminar la imagen si existe
            if ($producto->imagen_url) {
                Storage::disk('public')->delete($producto->imagen_url);
            }

            $producto->delete();
            return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error eliminando producto: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error eliminando producto: ' . $e->getMessage()]);
        }
    }
}