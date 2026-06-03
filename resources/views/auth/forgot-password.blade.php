@extends('layouts.app')

@section('titulo_superior', 'Recuperar Contraseña - SGI')
@section('subtitulo', 'Te enviaremos un enlace seguro para restablecer tu clave')

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

                    @if (session('status'))
                        <div class="alert alert-success p-2 mb-3" style="border-radius: 10px; font-size: 0.9rem;">
                            {{ session('status') }}
                            @if (session('reset_url'))
                                <hr class="my-2">
                                <a href="{{ session('reset_url') }}" class="alert-link small fw-bold d-block text-break">
                                    {{ session('reset_url') }}
                                </a>
                            @endif
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

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <p class="text-muted small mb-3">
                            Introduce el correo electrónico asociado a tu cuenta y te enviaremos las instrucciones de recuperación.
                        </p>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="usuario@correo.com" value="{{ old('email') }}" required autofocus>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm fw-bold mb-2" style="border-radius: 10px;">
                            Enviar Enlace al Correo
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
