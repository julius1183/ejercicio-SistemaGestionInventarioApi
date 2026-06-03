<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    /**
     * Muestra el formulario para cambiar la contraseña.
     */
    public function cambiarPassword()
{
    return view('perfil.cambiar-password');
}

    /**
     * Procesa la actualización de la contraseña en la base de datos.
     */
    public function actualizarPassword(Request $request)
    {
        // 1. Validar los datos de entrada
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:8|confirmed',
        ], [
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmation de la nueva contraseña no coincide.',
        ]);

        $user = Auth::user();

        // 2. Verificar si la contraseña actual digitada coincide con la de la BD
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }

        // 3. Actualizar la contraseña encriptada
        $user->password = Hash::make($request->new_password);
        $user->save();

        // 4. Redireccionar con un mensaje de éxito
        return back()->with('success', '¡Contraseña actualizada con éxito!');
    }
}