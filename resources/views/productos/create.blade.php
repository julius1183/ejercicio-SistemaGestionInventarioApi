@extends('layouts.app')

@section('content')

<style>
    body {
        /* Usamos la misma imagen que funcionó en proveedores para mantener la identidad del SGI */
        background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                          url('{{ asset("img/fondo.png") }}'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
    }
    
    /* Hacemos que el contenedor principal tenga un toque de transparencia elegante */
    .container.mt-5 {
        background: rgba(255, 255, 255, 0.9); 
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        margin-bottom: 50px;
    }

    .table-dark {
        background-color: #212529 !important;
    }
</style>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary mb-3 btn-sm">
                ← Volver al Inventario
            </a>

            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-dark text-white py-3">
                    <h4 class="mb-0 text-center">Registrar Nuevo Producto</h4>
                </div>
                <div class="card-body p-4">
                    <form id="formProducto">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nombre del Producto</label>
                                <input type="text" id="nombre" class="form-control" required placeholder="Ej: Monitor 24 pulg">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Categoría</label>
                                <input type="text" id="categoria" class="form-control" placeholder="Ej: Periféricos">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Precio (USD)</label>
                                <input type="number" id="precio" step="0.01" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Stock Inicial</label>
                                <input type="number" id="stock" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción (Opcional)</label>
                            <textarea id="descripcion" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-dark btn-lg shadow">Guardar en Inventario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Lógica para consumir la API de guardado vía JavaScript
    document.getElementById('formProducto').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const datos = {
            nombre: document.getElementById('nombre').value,
            categoria: document.getElementById('categoria').value,
            precio: document.getElementById('precio').value,
            stock: document.getElementById('stock').value,
            descripcion: document.getElementById('descripcion').value
        };

        try {
            const response = await fetch('/api/productos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datos)
            });

            if (response.ok) {
                alert('¡Producto registrado con éxito!');
                window.location.href = "{{ route('productos.index') }}";
            } else {
                alert('Error al guardar el producto.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
@endsection