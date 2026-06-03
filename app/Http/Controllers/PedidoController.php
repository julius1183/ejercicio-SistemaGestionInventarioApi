<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['user', 'detalles.producto'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.create', [
            'usuarioActual' => Auth::user(),
            'productos'     => Producto::orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Debes iniciar sesión para registrar pedidos.',
            ]);
        }

        $request->validate([
            'cliente_destinatario'   => 'required|string|max:255',
            'direccion_entrega'      => 'required|string',
            'fecha_solicitud'        => 'required|date',
            'fecha_entrega_estimada' => 'nullable|date|after_or_equal:fecha_solicitud',
            'observaciones'          => 'nullable|string',
            'producto_id'            => 'required|exists:productos,id',
            'cantidad'               => 'required|integer|min:1',
        ], [
            'cliente_destinatario.required' => 'El nombre del cliente es obligatorio.',
            'direccion_entrega.required'    => 'La dirección de entrega es obligatoria.',
            'fecha_solicitud.required'      => 'La fecha de solicitud es obligatoria.',
            'fecha_entrega_estimada.after_or_equal' => 'La fecha estimada no puede ser anterior a la fecha de solicitud.',
            'producto_id.required'          => 'Debes seleccionar un producto.',
            'cantidad.required'             => 'La cantidad es obligatoria.',
            'cantidad.min'                  => 'La cantidad debe ser al menos 1.',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $cantidad = (int) $request->cantidad;
        $precioUnitario = (float) $producto->precio;
        $costoTotal = $precioUnitario * $cantidad;

        $añoActual = date('Y');
        $ultimoPedido = Pedido::whereYear('created_at', $añoActual)->latest()->first();
        $consecutivo = $ultimoPedido ? ((int) substr($ultimoPedido->numero_pedido, -3)) + 1 : 1;
        $numeroPedido = 'PED-'.$añoActual.'-'.str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

        DB::transaction(function () use ($request, $producto, $cantidad, $precioUnitario, $costoTotal, $numeroPedido) {
            $pedido = Pedido::create([
                'user_id'                => Auth::id(),
                'numero_pedido'          => $numeroPedido,
                'cliente_destinatario'   => $request->cliente_destinatario,
                'direccion_entrega'      => $request->direccion_entrega,
                'estado'                 => 'Pendiente',
                'fecha_solicitud'        => $request->fecha_solicitud,
                'fecha_entrega_estimada' => $request->fecha_entrega_estimada,
                'observaciones'          => $request->observaciones,
                'costo_total'            => $costoTotal,
            ]);

            PedidoDetalle::create([
                'pedido_id'        => $pedido->id,
                'producto_id'      => $producto->id,
                'cantidad'         => $cantidad,
                'precio_unitario'  => $precioUnitario,
                'subtotal'         => $costoTotal,
            ]);
        });

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido registrado correctamente con el código '.$numeroPedido);
    }

    public function show($id)
    {
        $pedido = Pedido::with(['user', 'detalles.producto'])->findOrFail($id);

        return view('pedidos.show', compact('pedido'));
    }

    public function marcarEntregado($id)
    {
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);

        if ($pedido->estado === 'Entregado') {
            return back()->with('error', 'Este pedido ya fue marcado como entregado.');
        }

        if ($pedido->detalles->isEmpty()) {
            return back()->with('error', 'Este pedido no tiene productos asociados. No se puede descontar inventario.');
        }

        try {
            DB::transaction(function () use ($pedido) {
                foreach ($pedido->detalles as $detalle) {
                    $producto = $detalle->producto;

                    if ($producto->stock < $detalle->cantidad) {
                        throw new \Exception(
                            "Stock insuficiente para «{$producto->nombre}». Disponible: {$producto->stock}, pedido: {$detalle->cantidad}."
                        );
                    }

                    $producto->stock -= $detalle->cantidad;
                    $producto->save();

                    Stock::create([
                        'producto_id'     => $producto->id,
                        'cantidad'        => $detalle->cantidad,
                        'tipo_movimiento' => 'salida',
                        'observaciones'   => "Salida automática por pedido {$pedido->numero_pedido} (entregado)",
                    ]);
                }

                $pedido->estado = 'Entregado';
                $pedido->save();
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', "Pedido {$pedido->numero_pedido} entregado. Se descontó el inventario de productos.");
    }

     public function cancelar($id)
  {
    // 1. Buscar el pedido
    $pedido = Pedido::findOrFail($id);

    // 2. Cambiar el estado a Cancelado
    $pedido->estado = 'Cancelado';
    $pedido->save();

    // 3. Redireccionar de vuelta con un mensaje de éxito
    return redirect()->route('pedidos.index')->with('success', 'El pedido ' . $pedido->numero_pedido . ' ha sido cancelado correctamente.');
  }


}
