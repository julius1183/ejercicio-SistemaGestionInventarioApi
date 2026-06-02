<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    // --- PARTE DE LA API ---
    public function getApiProductos()
    {
        return response()->json(Producto::all(), 200);
    }

    // --- PARTE DE LA VISTA WEB ---
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // AGREGAMOS ESTA FUNCIÓN (Es la que te pedía el error de la imagen)
    public function create()
    {
        return view('productos.create');
    }

    public function storeApi(Request $request)
    {
        // Validamos los datos
        $request->validate([
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'stock'  => 'required|integer',
        ]);

        // Creamos el producto en la DB
        $nuevoProducto = Producto::create($request->all());

        return response()->json([
            'mensaje' => 'Producto creado con éxito',
            'producto' => $nuevoProducto
        ], 201);
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre'      => 'required|string|max:255',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'categoria'   => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $producto->update($validated);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}