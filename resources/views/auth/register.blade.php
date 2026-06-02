@extends('layouts.app')

@section('titulo_superior', 'Crear una Nueva Cuenta - SGI')
@section('subtitulo', 'Regístrate para acceder al sistema de inventario')

@section('content')
<style>
    /* Fondo de pantalla completa igual al Login */
    body {
        background: url("{{ asset('img/fondo.png') }}") no-repeat center center fixed;
        background-size: cover;
        height: 100vh;
    }

    /* Tarjeta con transparencia y desenfoque */
    .card {
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(5px);
        border-radius: 15px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    {{-- Envía los datos a una ruta que crearemos en el controlador --}}
                    <form method="POST" action="{{ route('registro.guardar') }}">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger p-2 mb-3" style="border-radius: 10px; font-size: 0.9rem;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" placeholder="Tu nombre" value="{{ old('name') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="usuario@correo.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la contraseña" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 shadow-sm fw-bold mb-3" style="border-radius: 10px;">
                            Registrarse e Ingresar
                        </button>

                        <hr class="text-muted my-3">

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none small text-primary fw-semibold">
                                ¿Ya tienes cuenta? Inicia sesión
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection