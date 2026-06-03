@extends('layouts.app') {{-- Ajusta si tu plantilla base tiene otro nombre --}}

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

<div class="container-fluid py-4" style="background: url('/img/fondo-almacen.jpg') no-repeat center center fixed; background-size: cover; min-height: 90vh;">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {{-- Tarjeta Flotante Translúcida --}}
            <div class="card shadow-lg border-0" style="background: rgba(255, 255, 255, 0.94); backdrop-filter: blur(10px); border-radius: 20px;">
                
                {{-- Encabezado --}}
                <div class="card-header border-0 pt-4 px-4 d-flex justify-content-between align-items-center" style="background: transparent;">
                    <div>
                        <h3 class="fw-bold text-dark mb-0">Registrar Nuevo Pedido</h3>
                        <p class="text-muted small mb-0">Ingrese los datos para el despacho de mercancía</p>
                    </div>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary fw-bold px-3" style="border-radius: 10px;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Listado
                    </a>
                </div>

                <hr class="mx-4 my-2 text-muted opacity-25">

                {{-- Cuerpo del Formulario --}}
                <div class="card-body p-4">
                    
                    {{-- Alertas de Error de Validación --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li class="fw-bold small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pedidos.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Usuario del sistema (se guarda automáticamente con Auth::id()) --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-secondary">Usuario que registra el pedido</label>
                                <input type="text" class="form-control bg-light" style="border-radius: 10px;"
                                       value="{{ $usuarioActual->nombre ?? 'Sin sesión' }} ({{ $usuarioActual->email ?? '' }})" readonly>
                                <small class="text-muted">Este dato se asocia automáticamente al guardar; no debes escribir tu usuario aquí.</small>
                            </div>

                            {{-- Cliente / Destinatario (persona o empresa que RECIBE el despacho) --}}
                            <div class="col-md-12 mb-3">
                                <label for="cliente_destinatario" class="form-label fw-bold text-secondary">Cliente que recibe el pedido</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" name="cliente_destinatario" id="cliente_destinatario" 
                                           class="form-control border-start-0" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
                                           placeholder="Nombre completo del cliente o empresa" value="{{ old('cliente_destinatario') }}" required>
                                </div>
                            </div>

                            {{-- Dirección de Entrega --}}
                            <div class="col-md-12 mb-3">
                                <label for="direccion_entrega" class="form-label fw-bold text-secondary">Dirección de Entrega</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                    </span>
                                    <input type="text" name="direccion_entrega" id="direccion_entrega" 
                                           class="form-control border-start-0" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
                                           placeholder="Ej: Calle 26 # 68-10, Bogotá" value="{{ old('direccion_entrega') }}" required>
                                </div>
                            </div>

                            {{-- Fecha de Solicitud --}}
                            <div class="col-md-6 mb-3">
                                <label for="fecha_solicitud" class="form-label fw-bold text-secondary">Fecha de Solicitud</label>
                                <input type="date" name="fecha_solicitud" id="fecha_solicitud" class="form-control" 
                                       style="border-radius: 10px;" value="{{ old('fecha_solicitud', date('Y-m-d')) }}" required>
                            </div>

                            {{-- Fecha de Entrega Estimada --}}
                            <div class="col-md-6 mb-3">
                                <label for="fecha_entrega_estimada" class="form-label fw-bold text-secondary">Fecha de Entrega Estimada (Opcional)</label>
                                <input type="date" name="fecha_entrega_estimada" id="fecha_entrega_estimada" class="form-control" 
                                       style="border-radius: 10px;" value="{{ old('fecha_entrega_estimada') }}">
                            </div>

                            <div class="col-12"><hr class="text-muted opacity-25"></div>

                            <div class="col-md-12 mb-3">
                                <label for="producto_id" class="form-label fw-bold text-secondary">Producto solicitado</label>
                                <select name="producto_id" id="producto_id" class="form-select" style="border-radius: 10px;" required>
                                    <option value="">-- Seleccione un producto --</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->id }}"
                                                data-precio="{{ $producto->precio }}"
                                                data-stock="{{ $producto->stock }}"
                                                {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                            {{ $producto->nombre }} — Stock: {{ $producto->stock }} — ${{ number_format($producto->precio, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="cantidad" class="form-label fw-bold text-secondary">Unidades</label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control"
                                       style="border-radius: 10px;" min="1" value="{{ old('cantidad', 1) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-secondary">Precio unitario</label>
                                <input type="text" id="precio_unitario" class="form-control bg-light" style="border-radius: 10px;" readonly value="$0">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold text-secondary">Costo total</label>
                                <input type="text" id="costo_total" class="form-control bg-light fw-bold text-primary" style="border-radius: 10px;" readonly value="$0">
                            </div>

                            {{-- Observaciones --}}
                            <div class="col-md-12 mb-4">
                                <label for="observaciones" class="form-label fw-bold text-secondary">Observaciones / Detalles del Pedido</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" rows="3" 
                                          style="border-radius: 10px;" placeholder="Escriba aquí si hay detalles específicos de la entrega o productos..."></textarea>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-light fw-bold px-4 me-md-2" style="border-radius: 10px;">Limpiar</button>
                            <button type="submit" class="btn btn-primary fw-bold px-5 shadow-sm" style="border-radius: 10px; background: #0d6efd;">
                                <i class="fas fa-save me-2"></i> Guardar Pedido
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    const selectProducto = document.getElementById('producto_id');
    const inputCantidad = document.getElementById('cantidad');
    const precioUnitario = document.getElementById('precio_unitario');
    const costoTotal = document.getElementById('costo_total');

    function actualizarTotales() {
        const option = selectProducto.options[selectProducto.selectedIndex];
        const precio = parseFloat(option?.dataset.precio || 0);
        const cantidad = parseInt(inputCantidad.value || 0, 10);
        const total = precio * cantidad;

        precioUnitario.value = '$' + precio.toLocaleString('es-CO');
        costoTotal.value = '$' + total.toLocaleString('es-CO');
    }

    selectProducto.addEventListener('change', actualizarTotales);
    inputCantidad.addEventListener('input', actualizarTotales);
    actualizarTotales();
</script>
@endsection