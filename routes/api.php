<?php

use App\Http\Controllers\Api\UsuarioController;

Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']); // equivalente a eliminar_usuarios.php
// y luego podrías añadir update/store según necesites

use Illuminate\Support\Facades\Route;

// Ruta para actualizar el rol
Route::put('/usuarios/{id}/rol', [UsuarioController::class, 'updateRol']);

// Ruta para dar de baja (eliminar o desactivar)
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);


