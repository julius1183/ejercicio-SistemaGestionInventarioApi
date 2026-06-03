<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PedidoApiController extends Controller
{
    /**
     * Obtener todos los pedidos para la App Móvil (Kotlin)
     */
    public function index()
    {
        // Traemos los pedidos con la información del usuario que los registró
        $pedidos = Pedido::with('user')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'status'  => 'success',
            'count'   => $pedidos->count(),
            'data'    => $pedidos
        ], 200);
    }

    /**
     * Registrar un pedido directamente desde el celular
     */
    public function store(Request $request)
    {
        // 1. Validar los datos que vienen de Retrofit
        $validator = Validator::make($request->all(), [
            'cliente_destinatario' => 'required|string|max:255',
            'direccion_entrega'    => 'required|string|max:255',
            'fecha_solicitud'      => 'required|date',
            'fecha_entrega_estimada' => 'nullable|date',
            'observaciones'        => 'nullable|string',
            'user_id'              => 'nullable|integer' // Por si mandas el ID del operario desde la App
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Generar el consecutivo automático (Misma lógica que tu Web)
        $añoActual = date('Y');
        $ultimoPedido = Pedido::whereYear('created_at', $añoActual)->latest()->first();
        $consecutivo = $ultimoPedido ? ((int)substr($ultimoPedido->numero_pedido, -3)) + 1 : 1;
        $numeroPedido = 'PED-' . $añoActual . '-' . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);

        // 3. Crear el registro en la base de datos
        $pedido = Pedido::create([
            'user_id'                => $request->user_id ?? 1, // Si no viene ID, asume el administrador por defecto
            'numero_pedido'          => $numeroPedido,
            'cliente_destinatario'   => $request->cliente_destinatario,
            'direccion_entrega'      => $request->direccion_entrega,
            'estado'                 => 'Pendiente',
            'fecha_solicitud'        => $request->fecha_solicitud,
            'fecha_entrega_estimada' => $request->fecha_entrega_estimada,
            'observaciones'          => $request->observaciones,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pedido registrado correctamente desde el dispositivo móvil',
            'data'    => $pedido
        ], 201);
    }


    /**
 * Cambiar el estado de un pedido (Entregado, Cancelado, etc.) desde la App Móvil
 */
public function updateEstado(Request $request, $id)
 {
    // 1. Validar que el estado enviado sea uno de los permitidos
    $validator = Validator::make($request->all(), [
        'estado' => 'required|string|in:Pendiente,Entregado,Cancelado'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Estado no válido. Use: Pendiente, Entregado o Cancelado.',
            'errors' => $validator->errors()
        ], 422);
    }

    // 2. Buscar el pedido en la base de datos
    $pedido = Pedido::find($id);

    if (!$pedido) {
        return response()->json([
            'status' => 'error',
            'message' => 'El pedido con ID ' . $id . ' no existe.'
        ], 404);
    }

    // 3. Actualizar el estado y guardar
    $pedido->estado = $request->estado;
    $pedido->save();

    return response()->json([
        'status' => 'success',
        'message' => 'El estado del pedido ' . $pedido->numero_pedido . ' ha sido actualizado a ' . $pedido->estado,
        'data' => $pedido
    ], 200);
 }
 
}