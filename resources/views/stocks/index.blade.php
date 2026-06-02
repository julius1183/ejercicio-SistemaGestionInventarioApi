@extends('layouts.app') {{-- O el nombre de tu layout base (ej. layouts.dashboard) --}}
@section('titulo_superior', 'Gestión de Stock')

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

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Historial de Movimientos de Inventario</h3>
            <a href="{{ route('stocks.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> + Registrar Movimiento
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th> 
                            <th>Cantidad</th>
                            <th>Tipo</th>
                            <th>Observaciones</th>
                            <th>Fecha de Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimientos as $movimiento)
                            <tr>
                                <td>{{ $movimiento->id }}</td>
                                <td>
                                    <strong>{{ $movimiento->producto->nombre ?? 'Producto Eliminado' }}</strong>
                                </td>
                                <td>{{ $movimiento->cantidad }} unidades</td>
                                <td>
                                    @if($movimiento->tipo_movimiento === 'entrada')
                                        <span class="badge bg-success text-white p-2">Entrada</span>
                                    @else
                                        <span class="badge bg-danger text-white p-2">Salida</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $movimiento->observaciones ?? 'Sin observaciones' }}</td>
                                <td>{{ $movimiento->created_at->format('d/m/Y h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No se han registrado movimientos de stock todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection