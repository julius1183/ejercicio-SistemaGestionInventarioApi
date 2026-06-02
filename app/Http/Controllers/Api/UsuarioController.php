<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    /**
     * Listar todos los usuarios.
     */
    public function index()
    {
        return response()->json(Usuario::all());
    }

    /**
     * Crear un nuevo usuario.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email|unique:usuarios,email',
            'rol'    => 'required|string|max:255',
            'estado' => 'required|integer',
        ]);

        $usuario = Usuario::create($data);

        return response()->json($usuario, 201);
    }

    /**
     * Mostrar un usuario específico.
     */
    public function show($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuario);
    }

    /**
     * Actualizar los datos generales de un usuario.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'email'  => 'required|email|unique:usuarios,email,' . $id,
            'rol'    => 'required|string|max:255',
            'estado' => 'required|integer',
        ]);

        $usuario->update($data);

        return response()->json($usuario);
    }

    /**
     * Actualizar específicamente el rol de un usuario.
     */
    public function updateRol(Request $request, $id)
    {
        $request->validate([
            'rol' => 'required|string'
        ]);

        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $usuario->rol = $request->rol;
        $usuario->save();

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'usuario' => $usuario
        ], 200);
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        
        if ($usuario) {
            $usuario->delete();
            return response()->json(['message' => 'Eliminado'], 200);
        }
        
        return response()->json(['message' => 'No encontrado'], 404);
    }
}