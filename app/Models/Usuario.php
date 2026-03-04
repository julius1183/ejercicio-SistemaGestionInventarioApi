<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    // Nombre de la tabla (ajusta si es necesario)
    protected $table = 'usuarios';

    // LA CLAVE: Desactiva los timestamps porque tu tabla no tiene 'created_at' y 'updated_at'
    public $timestamps = false;

    // Permitimos la asignación masiva de los campos que vas a editar
    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'estado',
    ];

    // Ocultar campos sensibles
    protected $hidden = [
        'password',
        'remember_token',
    ];
}