@extends('layouts.app')

@section('titulo_superior', 'Acceso al Sistema Gestión de Inventario (SGI)')
@section('subtitulo', 'Por favor, introduce tus credenciales')

@section('content')
<style>
    /* Fondo de pantalla completa */
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
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        @if (session('status'))
                            <div class="alert alert-success p-2 mb-3" style="border-radius: 10px; font-size: 0.9rem;">
                                {{ session('status') }}
                            </div>
                        @endif

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
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="usuario@correo.com" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-bold mb-0">Contraseña</label>
                                <a href="{{ route('password.request') }}" class="text-decoration-none small text-primary fw-semibold">¿Olvidaste tu contraseña?</a>
                            </div>
                            <input type="password" name="password" class="form-control" placeholder="********" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm fw-bold mb-3" style="border-radius: 10px;">
                            Entrar al Sistema
                        </button>

                        {{-- Línea divisoria sutil --}}
                        <hr class="text-muted my-3">

                        <div class="text-center">
                            <a href="{{ route('registro') }}" class="btn btn-outline-success w-100 fw-bold btn-sm py-2" style="border-radius: 10px;">
                                <i class="fas fa-user-plus me-1"></i> ¿No tienes cuenta? Regístrate aquí
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection