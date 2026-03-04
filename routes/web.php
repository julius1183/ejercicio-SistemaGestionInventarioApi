<?php

use App\Http\Controllers\UsuarioWebController;

Route::middleware(['web']) // más adelante puedes añadir middleware de auth
    ->get('/usuarios', [UsuarioWebController::class, 'index'])
    ->name('usuarios.index');
