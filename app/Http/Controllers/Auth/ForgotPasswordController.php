<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\Mailer\Exception\TransportException;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (TransportException) {
            return $this->respuestaEnlaceDesarrollo($request->email);
        }

        if ($status !== Password::RESET_LINK_SENT) {
            return back()->withErrors(['email' => 'No encontramos una cuenta con ese correo electrónico.']);
        }

        $respuesta = back()->with(
            'status',
            'Si el correo está registrado, recibirás un enlace para restablecer tu contraseña.'
        );

        if (app()->environment('local') && config('mail.default') === 'log') {
            $enlace = $this->generarEnlaceRestablecimiento($request->email);
            if ($enlace) {
                $respuesta->with('reset_url', $enlace)
                    ->with('status', 'Modo desarrollo: usa el enlace siguiente para restablecer tu contraseña (también quedó registrado en storage/logs/laravel.log).');
            }
        }

        return $respuesta;
    }

    private function respuestaEnlaceDesarrollo(string $email)
    {
        if (! app()->environment('local')) {
            return back()->withErrors([
                'email' => 'No se pudo enviar el correo. Verifica la configuración de correo o intenta más tarde.',
            ]);
        }

        $enlace = $this->generarEnlaceRestablecimiento($email);

        if (! $enlace) {
            return back()->withErrors(['email' => 'No encontramos una cuenta con ese correo electrónico.']);
        }

        return back()
            ->with('status', 'No hay servidor de correo activo. En modo desarrollo, usa este enlace para restablecer tu contraseña:')
            ->with('reset_url', $enlace);
    }

    private function generarEnlaceRestablecimiento(string $email): ?string
    {
        $usuario = Usuario::where('email', $email)->first();

        if (! $usuario) {
            return null;
        }

        $token = Password::broker()->createToken($usuario);

        return route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }
}
