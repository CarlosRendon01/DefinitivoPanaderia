<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF; // Usa el alias registrado
use Carbon\Carbon;

class MateriaController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-materia')->only('index');
        $this->middleware('permission:crear-materia', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-materia', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-materia', ['only' => ['destroy']]);
    }
 
    public function index(Request $request)
    {
        $materias = Materia::all();
        return view('materias.index', compact('materias'));
    }

    public function reporteDelDia()
{
    $fechaHoy = now()->toDateString();
    $materias = Materia::whereDate('updated_at', $fechaHoy)->get();

    $total = $materias->reduce(function ($carry, $materia) {
        return $carry + ($materia->cantidad * $materia->precio);
    }, 0);

    $pdf = PDF::loadView('materias.reporte', compact('materias', 'total', 'fechaHoy'));
    return $pdf->download('reporte_compras_del_dia_' . $fechaHoy . '.pdf');
}

public function reportePorRango(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    $materias = Materia::whereBetween('updated_at', [$request->fecha_inicio, $request->fecha_fin])->get();

    $total = $materias->reduce(function ($carry, $materia) {
        return $carry + ($materia->cantidad * $materia->precio);
    }, 0);

    $pdf = PDF::loadView('materias.reporte', [
        'materias' => $materias,
        'total' => $total,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin
    ]);
    return $pdf->download("reporte_compras_{$request->fecha_inicio}_a_{$request->fecha_fin}.pdf");
}

    public function showChargeForm()
    {
        $materias = Materia::all();
        return view('materias.cargar', compact('materias'));
    }

    public function charge(Request $request)
    {
        $cantidades = $request->input('cantidades', []);
    $unidades = $request->input('unidades', []);
    DB::beginTransaction();
    try {
        foreach ($cantidades as $materiaId => $cantidad) {
            $unidad = $unidades[$materiaId];
            $materia = Materia::findOrFail($materiaId);
            switch ($unidad) {
                case 'gramos':
                    $cantidad *= 50000; // Conversión de un bulto a gramos
                    break;
                case 'mililitros':
                    $cantidad *= 1000; // Conversión de litros a mililitros
                    break;
                case 'piezas':
                    $cantidad *= 360; // Conversión de caja a piezas
                    break;
            }
            $materia->increment('cantidad', $cantidad);
        }
        DB::commit();
        return redirect()->route('materias.index')->with('success', 'Cantidades actualizadas correctamente.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => 'Error al actualizar las cantidades: ' . $e->getMessage()])->withInput();
    }
    }

    // Mostrar el formulario para crear una nueva materia
    public function create()
    {
        return view('materias.crear');
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|unique:materias,nombre|string|max:255',
            'descripcion' => 'required|string',
            'proveedor' => 'required|string|max:255',
            'cantidad' => 'required|numeric|min:0',
            'precio' => 'required|numeric|min:0',
            'unidad' => 'required|in:gramos,mililitros,piezas', // Validar la unidad
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'imagen.image' => 'El archivo debe ser una imagen válida.',
            'imagen.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif o svg.',
            'imagen.max' => 'El tamaño máximo del archivo es de 2 MB.',
        ]);

        // Manejo de la imagen
        $imagenUrl = null;
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $imagen = $request->file('imagen');
            $imagenUrl = $imagen->store('imagenes_materias', 'public'); // Cambiamos la carpeta de almacenamiento
        }
        \Log::info('Archivo recibido: ', ['archivo' => $request->file('imagen')]);


        DB::beginTransaction();
        try {
            // Crear la materia
            $materia = Materia::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'proveedor' => $request->proveedor,
                'cantidad' => $request->cantidad,
                'precio' => $request->precio,
                'unidad' => $request->unidad, // Guardar la unidad
                'imagen_url' => $imagenUrl,
            ]);

            DB::commit();
            return redirect()->route('materias.index')->with('success', 'Materia creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Ocurrió un error al crear la materia: ' . $e->getMessage()])->withInput();
        }
    }
   


    // Mostrar una materia específica
    public function show(Materia $materia)
    {
        // return view('materias.show', compact('materia'));
    }

    // Mostrar el formulario para editar una materia existente
    public function edit(Materia $materia)
    {
        return view('materias.editar', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
{
    // Validación (similar al store, pero sin 'required' en imagen)
    $request->validate([
        'nombre' => 'required|string',
        'descripcion' => 'required|string',
        'proveedor' => 'required|string|max:255',
        'cantidad' => 'required|numeric|min:1',
        'precio' => 'required|numeric|min:0',
        'unidad' => 'required|in:gramos,mililitros,piezas,individual', // Actualizar la unidad
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ], [
        'imagen.image' => 'El archivo debe ser una imagen válida.',
        'imagen.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif o svg.',
        'imagen.max' => 'El tamaño máximo del archivo es de 2 MB.',
    ]);

    // Verificar que la cantidad ingresada sea mayor que la cantidad actual
    if ($request->cantidad < $materia->cantidad) {
        return back()->withErrors(['cantidad' => 'La cantidad ingresada debe ser mayor o igual que la cantidad actual.'])->withInput();
    }

    // Manejo de la imagen (similar al store, pero con eliminación de la imagen anterior si existe)
    $imagenUrl = $materia->imagen_url; // Mantener la imagen actual por defecto
    if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        if ($materia->imagen_url) {
            Storage::disk('public')->delete($materia->imagen_url); // Eliminar la imagen anterior
        }
        $imagen = $request->file('imagen');
        $imagenUrl = $imagen->store('imagenes_materias', 'public');
    }

    DB::beginTransaction();
    try {
        // Obtener todos los productos que contienen la materia prima a editar
        $productos = Producto::whereHas('materias', function($query) use ($materia) {
            $query->where('materia_id', $materia->id);
        })->get();

        foreach ($productos as $producto) {
            // Calcular el precio total de las materias primas en el producto
            $precioTotalMateriasPrimas = 0;
            foreach ($producto->materias as $materiaEnProducto) {
                $cantidadMateria = $materiaEnProducto->pivot->cantidad;
                if ($materiaEnProducto->id == $materia->id) {
                    // Utilizar el nuevo precio para la materia prima actualizada
                    $precioTotalMateriasPrimas += $request->precio * $cantidadMateria;
                } else {
                    // Utilizar el precio actual para otras materias primas
                    $precioTotalMateriasPrimas += $materiaEnProducto->precio * $cantidadMateria;
                }
            }

            // Calcular el nuevo precio del producto (sumando el 50%)
            $nuevoPrecioProducto = $precioTotalMateriasPrimas * 1.5;

            // Actualizar el precio del producto
            $producto->update(['precio' => $nuevoPrecioProducto]);
        }

        // Actualizar la materia prima
        $materia->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'proveedor' => $request->proveedor,
            'cantidad' => $request->cantidad,
            'unidad' => $request->unidad,
            'precio' => $request->precio,
            'imagen_url' => $imagenUrl, // Actualizar la URL de la imagen (si se cambió)
        ]);

        DB::commit();
        return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->withErrors(['error' => 'Ocurrió un error al actualizar la materia: ' . $e->getMessage()])->withInput();
    }
}

    

    

    // Eliminar una materia de la base de datos
    public function destroy(Materia $materia)
    {
        try {
            $materia->delete();
            return redirect()->route('materias.index')
                             ->with('success', 'Materia eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error eliminando materia: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Error eliminando materia: ' . $e->getMessage()]);
        }
    }
}
