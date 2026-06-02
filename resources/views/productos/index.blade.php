@extends('layouts.app')

@section('titulo_superior', 'Gestión de Productos')
@section('subtitulo', 'Bienvenido al Panel de Productos')

@section('content')
<style>
    body {
        /* Usamos la misma imagen que funcionó en proveedores para mantener la identidad del SGI */
        background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                          url('{{ asset("img/fondo.png") }}'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
    }
    
    /* Hacemos que el contenedor principal tenga un toque de transparencia elegante */
    .container.mt-5 {
        background: rgba(255, 255, 255, 0.9); 
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        margin-bottom: 50px;
    }

    .table-dark {
        background-color: #212529 !important;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Inventario de Productos</h2>
        <a href="{{ route('productos.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
             + Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nombre del Producto</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $prod)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">{{ $prod->id }}</td>
                            <td class="fw-bold">{{ $prod->nombre }}</td>
                            <td>
    @if($prod->stock == 0)
        <span class="badge bg-danger text-white p-2 w-100">
            <i class="fas fa-exclamation-circle"></i> Agotado
        </span>
    @elseif($prod->stock <= 10)
        <span class="badge bg-warning text-dark p-2 w-100">
            <i class="fas fa-exclamation-triangle"></i> Bajo Stock ({{ $prod->stock }})
        </span>
    @else
        <span class="badge bg-info text-white p-2 w-100">
            {{ $prod->stock }} unidades
        </span>
    @endif
</td>
                            <td>${{ number_format($prod->precio, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('productos.edit', $prod) }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 me-2">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('productos.destroy', $prod) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-muted">No hay productos registrados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection