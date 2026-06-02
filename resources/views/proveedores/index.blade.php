<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGI - Lista de Proveedores</title>
    <!-- Bootstrap para el diseño -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* 
               IMPORTANTE: Guarda tu imagen en public/images/fondo_sgi.jpg 
               El linear-gradient ayuda a que el contenido sea legible si la imagen es muy clara.
            */
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                              url('{{ asset("img/fondo.png") }}'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.98); /* Un blanco casi sólido para máxima legibilidad */
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 5rem;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5); /* Sombra más profunda para dar relieve */
        }
        .table thead {
            background-color: #212529;
            color: white;
        }
        .btn-success {
            background-color: #198754;
            transition: 0.3s;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.4);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark fw-bold">Gestión de Proveedores</h2>
                <div>
                    <a href="/" class="btn btn-outline-secondary rounded-pill me-2">Volver al Panel</a>
                    <a href="{{ route('proveedores.create') }}" class="btn btn-success rounded-pill px-4">
                        + Nuevo Proveedor
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>NIT</th>
                            <th>Teléfono</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $prov)
                        <tr>
                            <td class="fw-bold text-muted">{{ $prov->id }}</td>
                            <td>{{ $prov->nombre }}</td>
                            <td>{{ $prov->nit }}</td>
                            <td>{{ $prov->telefono ?? 'N/A' }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('proveedores.edit', $prov) }}" class="btn btn-warning btn-sm px-3 rounded-start-pill">Editar</a>
                                    
                                    <form action="{{ route('proveedores.destroy', $prov) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-3 rounded-end-pill" onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>