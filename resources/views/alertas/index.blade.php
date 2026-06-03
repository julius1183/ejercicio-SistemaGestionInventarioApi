@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                          url('{{ asset("img/fondo.png") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
    }

    .card-blur {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        border-radius: 20px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card card-blur shadow-lg border-0 p-4">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-dark mb-0">Centro de Notificaciones y Alertas</h3>
                        <p class="text-muted small mb-0">Monitoreo automático de rotación crítica y desabastecimiento</p>
                    </div>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary fw-bold px-3 btn-sm" style="border-radius: 10px;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Panel
                    </a>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-danger bg-opacity-10 text-danger p-3" style="border-radius: 15px;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="small mb-1 fw-bold">Productos Sin Stock (Agotado Crítico)</h6>
                                    <h3 class="fw-bold mb-0">{{ $sinStock }}</h3>
                                </div>
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-warning bg-opacity-10 text-warning-emphasis p-3" style="border-radius: 15px;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="small mb-1 fw-bold">Productos en Stock Mínimo (Por Agotarse)</h6>
                                    <h3 class="fw-bold mb-0">{{ $stockBajo }}</h3>
                                </div>
                                <i class="fas fa-boxes fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="border-top-left-radius: 10px;">Producto</th>
                                <th>Stock Actual</th>
                                <th>Stock Mínimo Permitido</th>
                                <th style="border-top-right-radius: 10px;" class="text-center">Estado de Alerta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alertas as $producto)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $producto->nombre }}</td>
                                    <td>
                                        <span class="fs-5 fw-bold {{ $producto->stock == 0 ? 'text-danger' : 'text-warning-emphasis' }}">
                                            {{ $producto->stock }}
                                        </span> Unidades
                                    </td>
                                    <td class="text-muted">{{ $producto->stock_minimo }} Unidades</td>
                                    <td class="text-center">
                                        @if($producto->stock == 0)
                                            <span class="badge bg-danger px-3 py-2 text-uppercase fw-bold" style="border-radius: 8px;">Agotado</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2 text-uppercase fw-bold" style="border-radius: 8px;">Stock Bajo</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-success fw-bold">
                                        <i class="fas fa-check-circle me-2"></i> ¡Excelente! Todo tu inventario se encuentra por encima del stock mínimo.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection