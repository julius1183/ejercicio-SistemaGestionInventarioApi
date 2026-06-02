<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Laragon buscará la tabla "productos" por defecto
    protected $table = 'productos';

    // Desactivamos timestamps si no los tienes en tu tabla
    public $timestamps = false;

    // Campos que permitimos llenar
    protected $fillable = [
        'nombre',
        'descripcion',
        'stock',
        'precio',
        'categoria'
    ];
}