<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        return response()->json(Proveedor::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'               => 'required|string|max:255',
            'nit'                  => 'required|string|max:255|unique:proveedores,nit',
            'contacto'             => 'nullable|string|max:255',
            'telefono'             => 'nullable|string|max:255',
            'email'                => 'nullable|email|max:255',
            'direccion'            => 'nullable|string|max:500',
            'categoria_principal'  => 'nullable|string|max:255',
        ]);

        $proveedor = Proveedor::create($validated);

        return response()->json($proveedor, 201);
    }

    public function show(Proveedor $proveedor)
    {
        return response()->json($proveedor);
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'nombre'               => 'required|string|max:255',
            'nit'                  => 'required|string|max:255|unique:proveedores,nit,'.$proveedor->id,
            'contacto'             => 'nullable|string|max:255',
            'telefono'             => 'nullable|string|max:255',
            'email'                => 'nullable|email|max:255',
            'direccion'            => 'nullable|string|max:500',
            'categoria_principal'  => 'nullable|string|max:255',
        ]);

        $proveedor->update($validated);

        return response()->json($proveedor);
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return response()->json(null, 204);
    }
}
