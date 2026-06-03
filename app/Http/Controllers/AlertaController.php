<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class AlertaController extends Controller
{
    public function index()
    {
        // Traer productos que estén por debajo o igual al stock mínimo
        $alertas = Producto::whereRaw('stock <= stock_minimo')
            ->orderBy('stock', 'asc')
            ->get();

        // Contadores rápidos para los KPIs de la vista
        $sinStock = Producto::where('stock', 0)->count();
        $stockBajo = Producto::whereRaw('stock > 0 AND stock <= stock_minimo')->count();

        return view('alertas.index', compact('alertas', 'sinStock', 'stockBajo'));
    }
}