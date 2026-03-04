<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario; // Asegúrate de que tu modelo se llame 'Usuario' o 'User'

class UsuarioController extends Controller
{
    public function updateRol(Request $request, $id)
    {
        // 1. Validar que el rol sea uno de los permitidos
        $request->validate([
            'rol' => 'required|string'
        ]);

        // 2. Buscar al usuario (Usamos el modelo 'Usuario' según tus capturas anteriores)
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // 3. Actualizar y guardar
        $usuario->rol = $request->rol;
        $usuario->save();

        return response()->json([
            'message' => 'Rol actualizado correctamente',
            'usuario' => $usuario
        ], 200);
    }

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