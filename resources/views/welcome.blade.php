@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    body {
        background: url("{{ asset('img/fondo.png') }}") no-repeat center center fixed;
        background-size: cover;
        height: 100vh;
        overflow: hidden;
    }

    .swiper {
        width: 100%;
        padding-top: 50px;
        padding-bottom: 80px; /* Más espacio para los puntitos de abajo */
    }

    .swiper-slide {
        background-position: center;
        background-size: cover;
        width: 320px;
    }

    .card-modulo {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 25px;
        text-align: center;
        padding: 30px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        height: 420px; /* Altura fija para que todos se vean iguales */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .img-modulo {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        object-fit: contain;
    }

    .swiper-button-next, .swiper-button-prev {
        color: white;
        background: rgba(0,0,0,0.2);
        padding: 40px;
        border-radius: 50%;
    }
</style>

<div class="container-fluid pt-3 px-4">
    <div class="d-flex justify-content-between align-items-center">
        <div style="background: rgba(0,0,0,0.5); color: white; padding: 8px 20px; border-radius: 50px;">
            <i class="bi bi-person-circle"></i> <strong>{{ Auth::user()->nombre }}</strong>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger rounded-pill shadow-sm">Salir</button>
        </form>
    </div>
</div>

<div class="container text-center mt-4">
    <h1 class="text-white fw-bold" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.5);">Panel de Control SGI</h1>
</div>

<div class="swiper mySwiper">
    <div class="swiper-wrapper">
        
        <div class="swiper-slide">
            <div class="card card-modulo">
                <img src="{{ asset('img/gestion_productos.png') }}" class="img-modulo">
                <h3>Productos</h3>
                <p class="text-muted">Inventario y Stock</p>
                <a href="{{ route('productos.index') }}" class="btn btn-primary w-100 rounded-pill">Entrar</a>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="card card-modulo">
                <img src="{{ asset('img/usuarios_roles.png') }}" class="img-modulo">
                <h3>Usuarios</h3>
                <p class="text-muted">Roles y Accesos</p>
                <a href="{{ url('/usuarios') }}" class="btn btn-success w-100 rounded-pill">Entrar</a>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="card card-modulo">
                <img src="{{ asset('img/control_stock.png') }}" class="img-modulo">
                <h3>Stock</h3>
                <p class="text-muted">Administración de Stock</p>
                <a href="{{ url('/stocks') }}" class="btn btn-success w-100 rounded-pill">Entrar</a>
                <button class="btn btn-secondary w-100 rounded-pill" disabled></button>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="card card-modulo">
                <img src="{{ asset('img/entregas_pedidos.png') }}" class="img-modulo">
                <h3>Entregas</h3>
                <p class="text-muted">Gestión de Pedidos</p>
                <button class="btn btn-secondary w-100 rounded-pill" disabled>Próximamente</button>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="card card-modulo">
                <img src="{{ asset('img/alertas_notificaciones.png') }}" class="img-modulo">
                <h3>Alertas</h3>
                <p class="text-muted">Centro de Notificaciones</p>
                <button class="btn btn-secondary w-100 rounded-pill" disabled>Próximamente</button>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="card card-modulo">
                <img src="{{ asset('img/gestion_proveedores.png') }}" class="img-modulo">
                <h3>Proveedores</h3>
                <p class="text-muted">Gestión de Terceros</p>
                <a href="{{ route('proveedores.index') }}" class="btn btn-primary w-100 rounded-pill">Entrar</a>
            </div>
        </div>

        <div class="swiper-slide">
            <div class="card card-modulo">
                <img src="{{ asset('img/informes_analisis.png') }}" class="img-modulo">
                <h3>Análisis</h3>
                <p class="text-muted">Informes y Estadísticas</p>
                <button class="btn btn-secondary w-100 rounded-pill" disabled>Próximamente</button>
            </div>
        </div>

    </div> <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true, // Esto hace que gire infinitamente
        coverflowEffect: {
            rotate: 30, // Menos rotación para que se lean mejor
            stretch: 0,
            depth: 200,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
@endsection