@extends('layouts.app')

@section('content')

<style>
    body {
        /* Tu imagen de fondo personalizada con la capa elegante de opacidad */
        background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                          url('{{ asset("img/fondo.png") }}'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
    }
    
    /* Contenedor principal con transparencia elegante para que resalte el fondo */
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


<div class="container mt-5">
    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary mb-3">
        &larr; Volver al listado
    </a>

    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Pedido {{ $pedido->numero_pedido }}</h4>
            <span class="badge bg-light text-dark">{{ $pedido->estado }}</span>
        </div>
        <div class="card-body">
            <dl class="row mb-4">
                <dt class="col-sm-4">Registrado por</dt>
                <dd class="col-sm-8">{{ $pedido->user?->nombre ?? 'N/A' }}</dd>

                <dt class="col-sm-4">Cliente</dt>
                <dd class="col-sm-8">{{ $pedido->cliente_destinatario }}</dd>

                <dt class="col-sm-4">Dirección</dt>
                <dd class="col-sm-8">{{ $pedido->direccion_entrega }}</dd>

                <dt class="col-sm-4">Fecha solicitud</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($pedido->fecha_solicitud)->format('d/m/Y') }}</dd>

                <dt class="col-sm-4">Entrega estimada</dt>
                <dd class="col-sm-8">
                    {{ $pedido->fecha_entrega_estimada ? \Carbon\Carbon::parse($pedido->fecha_entrega_estimada)->format('d/m/Y') : 'Por definir' }}
                </dd>

                <dt class="col-sm-4">Observaciones</dt>
                <dd class="col-sm-8">{{ $pedido->observaciones ?? '—' }}</dd>
            </dl>

            <h5 class="fw-bold mb-3">Productos del pedido</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Unidades</th>
                            <th class="text-end">Precio unitario</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedido->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->producto?->nombre ?? '—' }}</td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-end">${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                                <td class="text-end">${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Sin productos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Costo total</th>
                            <th class="text-end text-success">${{ number_format($pedido->costo_total ?? 0, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($pedido->estado !== 'Entregado' && $pedido->estado !== 'Cancelado' && $pedido->detalles->isNotEmpty())
                <form action="{{ route('pedidos.entregado', $pedido->id) }}" method="POST" class="mt-3"
                      onsubmit="return confirm('¿Marcar como entregado? Se descontará el stock del inventario.')">
                    @csrf
                    <button type="submit" class="btn btn-success fw-bold">
                        <i class="fas fa-check me-1"></i> Marcar como entregado
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
