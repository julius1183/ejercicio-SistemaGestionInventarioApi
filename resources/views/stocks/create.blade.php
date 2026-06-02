@extends('layouts.app')

@section('titulo_superior', 'Gestión de Stock')
@section('subtitulo', 'Control de Movimientos de Inventario')

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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Registrar Movimiento de Inventario</h4>
                </div>
                <div class="card-body">
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('stocks.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="producto_id" class="form-label">Seleccionar Producto</label>
                            <select name="producto_id" id="producto_id" class="form-select" required>
                                <option value="">-- Seleccione un Producto --</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">
                                        {{ $producto->nombre }} (Stock actual: {{ $producto->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_movimiento" class="form-label">Tipo de Movimiento</label>
                            <select name="tipo_movimiento" id="tipo_movimiento" class="form-select" required>
                                <option value="entrada">Entrada (+ Sumar al Inventario)</option>
                                <option value="salida">Salida (- Restar al Inventario)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad de Unidades</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones (Opcional)</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" rows="3" placeholder="Ej: Compra a proveedor, Ajuste por daño..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Movimiento</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection