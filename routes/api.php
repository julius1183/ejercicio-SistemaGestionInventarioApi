<?php

use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\AuthController; 


Route::get('/usuarios', [UsuarioController::class, 'index']);

// y luego podrías añadir update/store según necesites

use Illuminate\Support\Facades\Route;
// **NUEVA**: crear usuario
Route::post('/usuarios', [UsuarioController::class, 'store']);
// Ruta para actualizar el rol
Route::put('/usuarios/{id}/rol', [UsuarioController::class, 'updateRol']);

// Ruta para dar de baja (eliminar o desactivar)
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);

Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);



// Ruta pública para loguearse
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (el usuario debe enviar el Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/perfil', function (Request $request) {
        return $request->user();
    });
    
    // Aquí pondrías tu ruta de /usuarios si quieres que sea privada
    // Route::get('/usuarios', [UsuarioController::class, 'index']);



    Route::middleware('auth:sanctum')->get('/user-prueba', function (Request $request) {
    return $request->user();
});

Route::get('/usuarios', [AuthController::class, 'index']);

});

use App\Http\Controllers\ProductoController;

// Endpoint para que cualquier app (o tu propia web) obtenga los productos
Route::get('/productos', [ProductoController::class, 'getApiProductos']);

// Ruta para GUARDAR productos vía API
Route::post('/productos', [App\Http\Controllers\ProductoController::class, 'storeApi']);

use App\Http\Controllers\Api\ProveedorController;

// Prefijo automático: /api/proveedores
Route::apiResource('proveedores', ProveedorController::class);


use App\Http\Controllers\Api\StockController;

// Rutas protegidas o públicas de tu API (añádela donde tengas las de productos/proveedores)
Route::get('/stocks', [StockController::class, 'index']);
Route::post('/stocks', [StockController::class, 'store']);