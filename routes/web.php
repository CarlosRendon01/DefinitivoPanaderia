<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\VentaController;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [WelcomeController::class, 'showWelcomePage'])->name('welcome');

Route::post('/usuarios/changePassword', [UsuarioController::class, 'changePassword'])->name('usuarios.changePassword');
Route::post('/usuarios/updateProfile', [UsuarioController::class, 'updateProfile'])->name('usuarios.updateProfile');
Route::get('/usuarios/user-list', [UsuarioController::class, 'getUserList'])->name('usuarios.getUserList');

Route::get('/materias/cargar', [MateriaController::class, 'showChargeForm'])->name('materias.showChargeForm');
Route::post('/materias/cargar', [MateriaController::class, 'charge'])->name('materias.charge');
Route::get('/productos/cargar', [ProductoController::class, 'showChargeForm'])->name('productos.showChargeForm');
Route::post('/productos/cargar', [ProductoController::class, 'charge'])->name('productos.charge');
Route::post('/ventas/corteDeCaja', [VentaController::class, 'corteDeCaja'])->name('ventas.corteDeCaja');
Route::get('/ventas/reporteDelDia', [VentaController::class, 'reporteDelDia'])->name('ventas.reporteDelDia');
Route::post('/ventas/reportePorRango', [VentaController::class, 'reportePorRango'])->name('ventas.reportePorRango');
Route::get('/productos/restantes', [ProductoController::class, 'restantes'])->name('productos.restantes');
Route::get('/materias/reporteDelDia', [MateriaController::class, 'reporteDelDia'])->name('materias.reporteDelDia');
Route::post('/materias/reportePorRango', [MateriaController::class, 'reportePorRango'])->name('materias.reportePorRango');

// Grupo de rutas protegidas por el middleware 'auth'
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('productos', ProductoController::class); 
    Route::resource('materias', MateriaController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('logs', LogController::class);
    Route::get('/ventas/crear', [VentaController::class, 'create']);
    Route::post('/productos/updateCantidad/{id}', [ProductoController::class, 'updateCantidad'])->name('productos.updateCantidad');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{id}/detalles', [VentaController::class, 'detalles']);
    Route::get('/ventas/{id}/pdf', [VentaController::class, 'generarPDF'])->name('ventas.pdf');
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

    Route::get('/pedidos/crear', [PedidoController::class, 'create']);
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{id}/detalles', [PedidoController::class, 'detalles']);
    Route::get('/pedidos/{id}/pdf', [PedidoController::class, 'generarPDF'])->name('pedidos.pdf');
    Route::post('/pedidos/{id}/finalizar', [PedidoController::class, 'finalizar'])->name('pedidos.finalizar');
    //Route::get('/grupos/{clave}/generarPDF', [GrupoController::class, 'generarPDF'])->name('grupos.generarPDF');    
});
