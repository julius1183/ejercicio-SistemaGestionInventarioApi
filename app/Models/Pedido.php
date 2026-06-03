<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Campos autorizados para asignación masiva
    protected $fillable = [
        'user_id',
        'numero_pedido',
        'cliente_destinatario',
        'direccion_entrega',
        'estado',
        'fecha_solicitud',
        'fecha_entrega_estimada',
        'observaciones',
        'costo_total',
    ];

    protected $casts = [
        'costo_total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(Usuario::class, 'user_id');
    }

    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}