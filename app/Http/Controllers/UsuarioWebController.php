<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class UsuarioWebController extends Controller
{
    public function index()
{
    // Cambia Usuario::where('estado', 1)->get() por esto:
    $usuarios = Usuario::all(); 
    return view('usuarios.index', compact('usuarios'));
}
}