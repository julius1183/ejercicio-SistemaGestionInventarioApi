<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            
            // Usamos la relación nativa y limpia de Laravel 10/11
            // Esto crea un BIGINT UNSIGNED automáticamente compatible con tu tabla productos
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            
            $table->integer('cantidad');
            $table->string('tipo_movimiento'); // 'entrada' o 'salida'
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};