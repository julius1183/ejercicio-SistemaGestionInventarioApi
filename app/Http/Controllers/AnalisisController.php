<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    public function index()
    {
        // 1. KPIs Rápidos (Sumas y Conteos)
        $totalIngresos = Pedido::where('estado', 'Entregado')->sum('costo_total');
        $pedidosCompletados = Pedido::where('estado', 'Entregado')->count();
        $pedidosCancelados = Pedido::where('estado', 'Cancelado')->count();
        $totalPedidos = Pedido::count();
        
        // Tasa de cancelación (evitando división por cero)
        $tasaCancelacion = $totalPedidos > 0 ? round(($pedidosCancelados / $totalPedidos) * 100, 1) : 0;

        // 2. Datos para Gráfico de Dona: Distribución de Estados
        $estadosData = Pedido::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        // Asegurar que existan las llaves en el array para evitar errores en JS
        $estados = [
            'Pendiente' => $estadosData['Pendiente'] ?? 0,
            'En Ruta'   => $estadosData['En Ruta'] ?? 0,
            'Entregado' => $estadosData['Entregado'] ?? 0,
            'Cancelado' => $estadosData['Cancelado'] ?? 0,
        ];

        // 3. Datos para Gráfico de Barras: Top 5 Productos más vendidos
        // Nota: Ajusta 'pedido_detalles' y las llaves si tus tablas se llaman distinto
        $topProductos = DB::table('pedido_detalles')
            ->join('productos', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('sum(pedido_detalles.cantidad) as total_vendido'))
            ->groupBy('productos.id', 'productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->take(5)
            ->get();

        return view('analisis.index', compact(
            'totalIngresos', 
            'pedidosCompletados', 
            'tasaCancelacion', 
            'estados',
            'topProductos'
        ));
    }
}