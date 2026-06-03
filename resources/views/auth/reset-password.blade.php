@extends('layouts.app')

@section('titulo_superior', 'Restablecer Contraseña - SGI')
@section('subtitulo', 'Elige una nueva contraseña para tu cuenta')

@section('content')
<style>
    body {
        background: url("{{ asset('img/fondo.png') }}") no-repeat center center fixed;
        background-size: cover;
        height: 100vh;
    }

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

                    @if ($errors->any())
                        <div class="alert alert-danger p-2 mb-3" style="border-radius: 10px; font-size: 0.9rem;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $email) }}" required readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Mínimo 8 caracteres" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Repite la contraseña" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm fw-bold mb-2" style="border-radius: 10px;">
                            Restablecer Contraseña
                        </button>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold text-secondary">
                                &larr; Volver al Inicio de Sesión
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
