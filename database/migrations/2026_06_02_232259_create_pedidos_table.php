<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            // Relación con el usuario que genera o entrega el pedido
            $table->foreignId('user_id')->constrained('usuarios')->onDelete('cascade');
            
            $table->string('numero_pedido')->unique(); // Ej: PED-2026-001
            $table->string('cliente_destinatario');
            $table->text('direccion_entrega');
            
            // Estados: 'Pendiente', 'En Ruta', 'Entregado', 'Cancelado'
            $table->enum('estado', ['Pendiente', 'En Ruta', 'Entregado', 'Cancelado'])->default('Pendiente');
            
            $table->date('fecha_solicitud');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
};
