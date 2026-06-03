<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class AlertaApiController extends Controller
{
    public function obtenerAlertas()
    {
        try {
            $alertas = Producto::whereRaw('stock <= stock_minimo')
                ->select('id', 'nombre', 'stock', 'stock_minimo')
                ->orderBy('stock', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'total_alertas' => $alertas->count(),
                'data' => $alertas
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener alertas: ' . $e->getMessage()
            ], 500);
        }
    }
}