<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .header-banner {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://via.placeholder.com/1200x300'); /* Aquí puedes poner tu imagen de almacén */
            background-size: cover;
            color: white;
            padding: 60px 0;
            text-align: center;
            margin-bottom: -50px;
        }
        .main-card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: none;
        }
        .badge-admin { background-color: #ffc107; color: #000; }
        .badge-almacen { background-color: #6c5ce7; }
        .badge-auxiliar { background-color: #00b894; }
    </style>
</head>
<body>

    <div class="header-banner">
        <h1>Gestión de Usuarios</h1>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card main-card">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Bienvenido al Panel de Usuarios: <strong>{{ auth()->user()->nombre ?? 'Usuario' }}</strong></h5>
                            <a href="#" class="btn btn-link text-decoration-none">← Volver al Dashboard</a>
                        </div>
                        
                        @yield('content')
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
async function darDeBaja(id) {
    if (!confirm('¿Estás seguro de que deseas dar de baja a este usuario?')) return;

    try {
        const response = await fetch(`/api/usuarios/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Seguridad de Laravel
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            // Elimina la fila de la tabla visualmente sin recargar
            document.getElementById(`fila-usuario-${id}`).remove();
            alert('Usuario eliminado con éxito');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>

</body>

</html>