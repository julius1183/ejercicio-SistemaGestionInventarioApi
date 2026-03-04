<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (! $usuario || ! Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'message' => 'Correo o contraseña incorrectos.',
            ], 401);
        }

        // Aquí podrías generar token (Sanctum/Passport/JWT). De momento, devolvemos datos básicos.
        return response()->json([
            'id'     => $usuario->id,
            'nombre' => $usuario->nombre,
            'rol'    => $usuario->rol,
        ]);
    }
}