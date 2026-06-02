<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGI - Registrar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Usamos la misma imagen que ya te funcionó en el index */
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                              url('{{ asset("img/fondo.png") }}'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center; /* Centra el formulario verticalmente */
            justify-content: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 800px; /* Un poco más angosto para formularios */
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }
        .form-label {
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="glass-card">
            <h2 class="text-primary fw-bold mb-4">Registrar Nuevo Proveedor</h2>
            
            <form action="{{ route('proveedores.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre de la Empresa</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Distribuidora Central" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIT</label>
                        <input type="text" name="nit" class="form-control" placeholder="900.000.000-1" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control">
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('proveedores.index') }}" class="btn btn-secondary rounded-pill px-4">Cancelar</a>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Guardar Proveedor</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>