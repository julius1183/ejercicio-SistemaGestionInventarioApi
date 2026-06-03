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

    .card-analytics {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        border-radius: 20px;
    }
</style>

<!-- CDN de Chart.js para los gráficos interactivos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid py-4" style="background: url('/img/fondo-almacen.jpg') no-repeat center center fixed; background-size: cover; min-height: 90vh;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <!-- Contenedor Principal Translúcido -->
            <div class="card card-analytics shadow-lg border-0 p-4">
                
                <!-- Encabezado del Módulo -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-dark mb-0">Informes y Estadísticas</h3>
                        <p class="text-muted small mb-0">Análisis de rendimiento y rotación de inventario del SGI</p>
                    </div>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-outline-secondary fw-bold px-3 btn-sm" style="border-radius: 10px;">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Panel
                    </a>
                </div>

                <!-- SECCIÓN DE KPIs (Tarjetas Rápidas) -->
                <div class="row g-3 mb-4">
                    <!-- KPI 1: Ingresos -->
                    <div class="col-md-4">
                        <div class="card border-0 bg-white shadow-sm p-3" style="border-radius: 15px;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted small mb-1 fw-bold">Total Ingresos (Entregados)</h6>
                                    <h3 class="fw-bold text-success mb-0">${{ number_format($totalIngresos, 0, ',', '.') }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 2: Pedidos Completados -->
                    <div class="col-md-4">
                        <div class="card border-0 bg-white shadow-sm p-3" style="border-radius: 15px;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted small mb-1 fw-bold">Pedidos Completados</h6>
                                    <h3 class="fw-bold text-dark mb-0">{{ $pedidosCompletados }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 3: Tasa de Cancelación -->
                    <div class="col-md-4">
                        <div class="card border-0 bg-white shadow-sm p-3" style="border-radius: 15px;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted small mb-1 fw-bold">Tasa de Cancelación</h6>
                                    <h3 class="fw-bold text-danger mb-0">{{ $tasaCancelacion }}%</h3>
                                </div>
                                <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                                    <i class="fas fa-times-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN DE GRÁFICOS -->
                <div class="row g-4">
                    <!-- Gráfico 1: Distribución de Estados de Pedidos -->
                    <div class="col-md-5">
                        <div class="card border-0 bg-white shadow-sm p-4 h-100" style="border-radius: 15px;">
                            <h5 class="fw-bold text-dark mb-3">Estado de los Pedidos</h5>
                            <div class="chart-container" style="position: relative; height:280px;">
                                <canvas id="chartEstados"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Gráfico 2: Top Productos más pedidos -->
                    <div class="col-md-7">
                        <div class="card border-0 bg-white shadow-sm p-4 h-100" style="border-radius: 15px;">
                            <h5 class="fw-bold text-dark mb-3">Top 5 Productos de Mayor Rotación</h5>
                            <div class="chart-container" style="position: relative; height:280px;">
                                <canvas id="chartProductos"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Configuración de los Gráficos mediante JavaScript -->
<script>
    // 1. Renderizado del Gráfico de Dona (Estados)
    const ctxEstados = document.getElementById('chartEstados').getContext('2d');
    new Chart(ctxEstados, {
        type: 'doughnut',
        data: {
            labels: ['Pendiente', 'En Ruta', 'Entregado', 'Cancelado'],
            datasets: [{
                data: [
                    {{ $estados['Pendiente'] }},
                    {{ $estados['En Ruta'] }},
                    {{ $estados['Entregado'] }},
                    {{ $estados['Cancelado'] }}
                ],
                backgroundColor: ['#ffc107', '#0dcaf0', '#198754', '#dc3545'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 2. Renderizado del Gráfico de Barras (Top Productos)
    const ctxProductos = document.getElementById('chartProductos').getContext('2d');
    new Chart(ctxProductos, {
        type: 'bar',
        data: {
            labels: [
                @foreach($topProductos as $prod)
                    '{{ $prod->nombre }}',
                @endforeach
            ],
            datasets: [{
                label: 'Unidades Solicitadas',
                data: [
                    @foreach($topProductos as $prod)
                        {{ $prod->total_vendido }},
                    @endforeach
                ],
                backgroundColor: '#0d6efd',
                borderRadius: 8,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endsection