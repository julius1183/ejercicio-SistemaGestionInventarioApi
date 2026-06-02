<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Listar el historial de movimientos de stock
     */
    public function index()
    {
        $movimientos = Stock::with('producto')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $movimientos
        ], 200);
    }

    /**
     * Registrar un movimiento de stock y alterar el inventario real
     */
    public function store(Request $request)
    {
        // 1. Validamos los datos que llegan de Thunder Client
        $request->validate([
            'producto_id'     => 'required|exists:productos,id',
            'cantidad'        => 'required|integer|min:1',
            'tipo_movimiento' => 'required|in:entrada,salida',
            'observaciones'   => 'nullable|string'
        ]);

        // 2. Transacción de Base de Datos para evitar descuadres
        return DB::transaction(function () use ($request) {
            
            $producto = Producto::find($request->producto_id);

            // 3. Modificamos el stock según sea entrada o salida
            if ($request->tipo_movimiento === 'entrada') {
                $producto->stock += $request->cantidad;
            } else {
                if ($producto->stock < $request->cantidad) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Stock insuficiente para realizar esta salida.'
                    ], 400);
                }
                $producto->stock -= $request->cantidad;
            }

            // Guardamos el nuevo stock en la tabla de productos
            $producto->save();

            // 4. Creamos el registro en el historial de stocks
            $movimiento = Stock::create([
                'producto_id'     => $request->producto_id,
                'cantidad'        => $request->cantidad,
                'tipo_movimiento' => $request->tipo_movimiento,
                'observaciones'   => $request->observaciones
            ]);

            // 5. Respondemos éxito
            return response()->json([
                'status' => 'success',
                'message' => 'Movimiento de inventario registrado con éxito.',
                'data' => $movimiento
            ], 201);
        });
    }
}