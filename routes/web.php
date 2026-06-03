<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioWebController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorWebController;
use App\Http\Controllers\StockWebController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AnalisisController; // <- Importación del nuevo controlador organizada aquí arriba
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\AlertaController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas y Autenticación
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registro de nuevos usuarios
Route::get('/registro', [ApiAuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [ApiAuthController::class, 'registrar'])->name('registro.guardar');

// Recuperación de contraseña (olvidé mi contraseña)
Route::get('/olvide-contrasena', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/olvide-contrasena', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/restablecer-contrasena/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/restablecer-contrasena', [ResetPasswordController::class, 'reset'])->name('password.update');


/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Solo Usuarios Autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Inicio / Bienvenida
    Route::get('/', function () {
        return view('welcome');
    });

    // Gestión de Usuarios
    Route::get('/usuarios', [UsuarioWebController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UsuarioWebController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios/guardar', [UsuarioWebController::class, 'store'])->name('usuarios.store');
    

    // Gestión de Proveedores
    Route::get('/proveedores', [ProveedorWebController::class, 'index'])->name('proveedores.index');
    Route::get('/proveedores/crear', [ProveedorWebController::class, 'create'])->name('proveedores.create');
    Route::post('/proveedores', [ProveedorWebController::class, 'store'])->name('proveedores.store');
    Route::get('/proveedores/{proveedor}/editar', [ProveedorWebController::class, 'edit'])->name('proveedores.edit');
    Route::put('/proveedores/{proveedor}', [ProveedorWebController::class, 'update'])->name('proveedores.update');
    Route::delete('/proveedores/{proveedor}', [ProveedorWebController::class, 'destroy'])->name('proveedores.destroy');

    // Gestión de Productos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos/guardar', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    // Gestión de Stock
    Route::get('/stocks', [StockWebController::class, 'index'])->name('stocks.index');
    Route::get('/stocks/crear', [StockWebController::class, 'create'])->name('stocks.create');
    Route::post('/stocks/guardar', [StockWebController::class, 'store'])->name('stocks.store');

    // Gestión de Perfil
    Route::get('/perfil/cambiar-contratena', [PerfilController::class, 'cambiarPassword'])->name('password.cambiar');
    Route::post('/perfil/actualizar-contratena', [PerfilController::class, 'actualizarPassword'])->name('password.actualizar');

    // Módulo de Entregas y Pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/crear', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos/guardar', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::post('/pedidos/{id}/entregado', [PedidoController::class, 'marcarEntregado'])->name('pedidos.entregado');
    Route::patch('/pedidos/{id}/cancelar', [PedidoController::class, 'cancelar'])->name('pedidos.cancelar');

    // Módulo de Análisis e Informes (¡Agregado aquí de forma segura!)
    Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis.index');

// Módulo de Alertas y Notificaciones (Web)
    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');

}); // <- Esta llave y paréntesis cierran de manera correcta TODO el grupo 'auth'