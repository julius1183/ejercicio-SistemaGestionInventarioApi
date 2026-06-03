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

    .container.mt-4 {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        margin-bottom: 50px;
    }

    .table-dark {
        background-color: #212529 !important;
    }
</style>

<div class="container-fluid py-4" style="background: url('/img/fondo-almacen.jpg') no-repeat center center fixed; background-size: cover; min-height: 90vh;">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(10px); border-radius: 20px;">

                <div class="card-header border-0 d-flex justify-content-between align-items-center pt-4 px-4" style="background: transparent;">
                    <div>
                        <h3 class="fw-bold text-dark mb-0">Gestión de Entregas y Pedidos</h3>
                        <p class="text-muted small mb-0">Control de despachos y solicitudes del SGI</p>
                    </div>
                    <a href="{{ route('pedidos.create') }}" class="btn btn-success fw-bold px-4 shadow-sm" style="border-radius: 10px;">
                        <i class="fas fa-plus-circle me-2"></i> Nuevo Pedido
                    </a>
                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                            <strong>¡Éxito!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                            <strong>Error:</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive" style="border-radius: 12px; overflow: hidden;">
                        <table class="table table-hover align-middle mb-0 bg-white">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-4">N° Pedido</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th class="text-center">Unidades</th>
                                    <th class="text-end">Costo total</th>
                                    <th class="text-center">Estado</th>
                                    <th>Registrado por</th>
                                    <th class="text-center pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pedidos as $pedido)
                                    @php $detalle = $pedido->detalles->first(); @endphp
                                    <tr>
                                        <td class="fw-bold ps-4 text-primary">{{ $pedido->numero_pedido }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $pedido->cliente_destinatario }}</div>
                                            <span class="text-muted small">{{ Str::limit($pedido->direccion_entrega, 25) }}</span>
                                        </td>
                                        <td>{{ $detalle?->producto?->nombre ?? '—' }}</td>
                                        <td class="text-center fw-bold">{{ $detalle?->cantidad ?? '—' }}</td>
                                        <td class="text-end fw-bold text-success">
                                            ${{ number_format($pedido->costo_total ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if($pedido->estado == 'Pendiente')
                                                <span class="badge bg-warning text-dark px-3 py-2 fw-bold" style="border-radius: 8px;">Pendiente</span>
                                            @elseif($pedido->estado == 'En Ruta')
                                                <span class="badge bg-info text-white px-3 py-2 fw-bold" style="border-radius: 8px;">En Ruta</span>
                                            @elseif($pedido->estado == 'Entregado')
                                                <span class="badge bg-success text-white px-3 py-2 fw-bold" style="border-radius: 8px;">Entregado</span>
                                            @else
                                                <span class="badge bg-danger text-white px-3 py-2 fw-bold" style="border-radius: 8px;">Cancelado</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-light text-dark border px-2 py-1">{{ $pedido->user?->nombre ?? 'N/A' }}</span></td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    Ver
                                                </a>
                                                
                                                @if($pedido->estado !== 'Entregado' && $pedido->estado !== 'Cancelado')
                                                    <form action="{{ route('pedidos.entregado', $pedido->id) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Marcar como entregado? Se descontará el stock del inventario.')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success fw-bold">
                                                            <i class="fas fa-check me-1"></i> Entregado
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('pedidos.cancelar', $pedido->id) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Estás seguro de que deseas cancelar este pedido? Esta acción no se puede deshacer.')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger fw-bold">
                                                            <i class="fas fa-times-circle me-1"></i> Cancelar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-5">
                                            <i class="fas fa-box-open fa-3x mb-3 text-secondary"></i>
                                            <p class="mb-0 fw-bold">No hay pedidos registrados en este momento</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        {{ $pedidos->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection