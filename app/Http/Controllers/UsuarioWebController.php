<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario; // Importamos el modelo que ya configuramos
use Illuminate\Support\Facades\Hash;

class UsuarioWebController extends Controller
{
    /**
     * Muestra la tabla de usuarios (La que ya tienes)
     */
    public function index()
    {
        $usuarios = Usuario::all(); 
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Guarda el usuario en la base de datos de Laragon
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            
        ]);

        // 2. Creamos el registro
        Usuario::create([
            'nombre'   => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Encriptación segura
            'rol'      => $request->rol,
            'estado'   => 'Activo', // Usamos el texto que definimos en la DB
        ]);

        // 3. Redirigimos al índice con un mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }
}