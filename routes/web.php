<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioWebController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorWebController; // Importación correcta
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| Gestión de Usuarios
|--------------------------------------------------------------------------
*/
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/usuarios', [UsuarioWebController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UsuarioWebController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios/guardar', [UsuarioWebController::class, 'store'])->name('usuarios.store');
});

/*
|--------------------------------------------------------------------------
| Gestión de Proveedores (Corregido para Web)
|--------------------------------------------------------------------------
*/
// Unificamos para que use siempre ProveedorWebController
Route::get('/proveedores', [ProveedorWebController::class, 'index'])->name('proveedores.index');
Route::get('/proveedores/crear', [ProveedorWebController::class, 'create'])->name('proveedores.create');
Route::post('/proveedores', [ProveedorWebController::class, 'store'])->name('proveedores.store');
Route::get('/proveedores/{proveedor}/editar', [ProveedorWebController::class, 'edit'])->name('proveedores.edit');
Route::put('/proveedores/{proveedor}', [ProveedorWebController::class, 'update'])->name('proveedores.update');
Route::delete('/proveedores/{proveedor}', [ProveedorWebController::class, 'destroy'])->name('proveedores.destroy');

/*
|--------------------------------------------------------------------------
| Gestión de Productos
|--------------------------------------------------------------------------
*/
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/productos/guardar', [ProductoController::class, 'store'])->name('productos.store');
Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

use App\Http\Controllers\StockWebController;

// Añade estas líneas junto a tus otras rutas web protegidas (debajo del login)
Route::get('/stocks', [StockWebController::class, 'index'])->name('stocks.index');
Route::get('/stocks/crear', [StockWebController::class, 'create'])->name('stocks.create');


Route::post('/stocks/guardar', [StockWebController::class, 'store'])->name('stocks.store');


use App\Http\Controllers\PerfilController;

// Rutas para la gestión del perfil de usuario
Route::get('/perfil/cambiar-contratena', [PerfilController::class, 'cambiarPassword'])->name('password.cambiar');
Route::post('/perfil/actualizar-contratena', [PerfilController::class, 'actualizarPassword'])->name('password.actualizar');

// Rutas para la recuperación de contraseña
Route::get('/olvide-contrasena', function () {
    return view('auth.forgot-password'); // O la vista que vayas a crear luego
})->name('password.request');

Route::post('/olvide-contrasena', function () {
    // Aquí irá la lógica de enviar el correo más adelante
})->name('password.email');

// Ruta para el registro de nuevos usuarios
Route::get('/registro', function () {
    return view('auth.register'); // O la vista que definas para registrarse
})->name('registro');

use App\Http\Controllers\API\AuthController;

// Rutas de Registro web apuntando al controlador que está en la carpeta API
Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.guardar');