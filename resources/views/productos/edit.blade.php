@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary mb-3 btn-sm">
                &larr; Volver al Inventario
            </a>

            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-dark text-white py-3">
                    <h4 class="mb-0 text-center">Editar Producto</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('productos.update', $producto) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre del Producto</label>
                                <input type="text" name="nombre" id="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{ old('nombre', $producto->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label fw-bold">Categor&iacute;a</label>
                                <input type="text" name="categoria" id="categoria"
                                       class="form-control @error('categoria') is-invalid @enderror"
                                       value="{{ old('categoria', $producto->categoria) }}">
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label fw-bold">Precio (USD)</label>
                                <input type="number" name="precio" id="precio" step="0.01"
                                       class="form-control @error('precio') is-invalid @enderror"
                                       value="{{ old('precio', $producto->precio) }}" required>
                                @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold">Stock</label>
                                <input type="number" name="stock" id="stock"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       value="{{ old('stock', $producto->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">Descripci&oacute;n (Opcional)</label>
                            <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                      rows="2">{{ old('descripcion', $producto->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg shadow">Actualizar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
