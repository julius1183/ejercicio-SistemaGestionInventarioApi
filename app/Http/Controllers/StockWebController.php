<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class StockWebController extends Controller
{
    /**
     * Muestra el historial de movimientos de inventario
     */
    public function index()
    {
        // Traemos los movimientos ordenados por el más reciente y con su relación de producto
        $movimientos = Stock::with('producto')->latest()->get();
        
        return view('stocks.index', compact('movimientos'));
    }

    /**
     * Muestra el formulario para registrar una nueva entrada o salida
     */
    public function create()
    {
        // Traemos todos los productos para listarlos en el selector del formulario
        $productos = Producto::all();
        
        return view('stocks.create', compact('productos'));
 
       }


/**
 * Procesa el formulario web, altera el stock del producto y guarda el historial
 */
public function store(Request $request)
{
    $request->validate([
        'producto_id'     => 'required|exists:productos,id',
        'cantidad'        => 'required|integer|min:1',
        'tipo_movimiento' => 'required|in:entrada,salida',
        'observaciones'   => 'nullable|string'
    ]);

    // Usamos la misma transacción segura que en la API
    \DB::transaction(function () use ($request) {
        $producto = \App\Models\Producto::find($request->producto_id);

        if ($request->tipo_movimiento === 'entrada') {
            $producto->stock += $request->cantidad;
        } else {
            if ($producto->stock < $request->cantidad) {
                // Si falla por falta de stock, lanzamos una excepción para cancelar la transacción
                throw new \Exception('Stock insuficiente para realizar esta salida.');
            }
            $producto->stock -= $request->cantidad;
        }

        $producto->save();

        \App\Models\Stock::create([
            'producto_id'     => $request->producto_id,
            'cantidad'        => $request->cantidad,
            'tipo_movimiento' => $request->tipo_movimiento,
            'observaciones'   => $request->observaciones
        ]);
    });

    return redirect()->route('stocks.index')->with('success', 'Movimiento registrado con éxito.');
}




}
