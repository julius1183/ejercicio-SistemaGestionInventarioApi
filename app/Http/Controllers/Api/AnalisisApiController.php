<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class AnalisisApiController extends Controller
{
    public function obtenerEstadisticas()
    {
        try {
            // 1. KPIs
            $totalIngresos = Pedido::where('estado', 'Entregado')->sum('costo_total');
            $pedidosCompletados = Pedido::where('estado', 'Entregado')->count();
            $pedidosCancelados = Pedido::where('estado', 'Cancelado')->count();
            $totalPedidos = Pedido::count();
            
            $tasaCancelacion = $totalPedidos > 0 ? round(($pedidosCancelados / $totalPedidos) * 100, 1) : 0;

            // 2. Estados de los pedidos (Incluyendo 'En Ruta' para el futuro)
            $estadosData = Pedido::select('estado', DB::raw('count(*) as total'))
                ->groupBy('estado')
                ->pluck('total', 'estado')
                ->toArray();

            $estados = [
                'Pendiente' => $estadosData['Pendiente'] ?? 0,
                'En Ruta'   => $estadosData['En Ruta'] ?? 0,
                'Entregado' => $estadosData['Entregado'] ?? 0,
                'Cancelado' => $estadosData['Cancelado'] ?? 0,
            ];

            // 3. Top Productos
            $topProductos = DB::table('pedido_detalles')
                ->join('productos', 'pedido_detalles.producto_id', '=', 'productos.id')
                ->select('productos.nombre', DB::raw('sum(pedido_detalles.cantidad) as total_vendido'))
                ->groupBy('productos.id', 'productos.nombre')
                ->orderBy('total_vendido', 'desc')
                ->take(5)
                ->get();

            // Retornamos la respuesta estructurada en JSON con código 200 OK
            return response()->json([
                'status' => 'success',
                'data' => [
                    'kpis' => [
                        'total_ingresos' => $totalIngresos,
                        'pedidos_completados' => $pedidosCompletados,
                        'tasa_cancelacion' => $tasaCancelacion . '%'
                    ],
                    'grafico_estados' => $estados,
                    'top_productos' => $topProductos
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar las estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }
}